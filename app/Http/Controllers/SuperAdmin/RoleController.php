<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')->get();

        return view('super-admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('super-admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'label' => 'required|string|max:255',
            'scope' => 'required|in:platform,charity',
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->label = $request->label;
        $role->scope = $request->scope;
        $role->guard_name = 'web';
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('super-admin.roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('users');

        $tenants = collect();
        if ($role->scope === 'charity') {
            $tenants = Tenant::orderBy('name')->get();
        }

        return view('super-admin.roles.show', compact('role', 'tenants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('super-admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'label' => 'required|string|max:255',
            'scope' => 'required|in:platform,charity',
        ]);

        if (! in_array($role->name, RoleName::values())) {
            $role->name = $request->name;
            $role->scope = $request->scope;
        }
        $role->label = $request->label;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('super-admin.roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('super-admin.roles.index')->with('error', 'لا يمكن حذف دور مرتبط بمستخدمين');
        }

        if (in_array($role->name, RoleName::values())) {
            return redirect()->route('super-admin.roles.index')->with('error', 'لا يمكن حذف الأدوار الأساسية للنظام');
        }

        $role->delete();

        return redirect()->route('super-admin.roles.index')->with('success', 'تم حذف الدور بنجاح');
    }

    public function assignUser(Request $request, Role $role)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        if ($role->scope === 'charity') {
            $rules['tenant_id'] = 'required|exists:tenants,id';
        }

        $request->validate($rules, [
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'tenant_id.required' => 'يجب تحديد الجمعية التابع لها هذا المستخدم.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $role->scope === 'charity' ? $request->tenant_id : null,
        ]);

        $user->assignRole($role->name);

        return back()->with('success', 'تم إنشاء المستخدم وإسناد الدور له بنجاح');
    }

    public function removeUser(Role $role, User $user)
    {
        // Don't let super admin remove their own super_admin role accidentally
        if ($role->name === RoleName::SuperAdmin->value && auth()->id() === $user->id) {
            return back()->with('error', 'لا يمكنك إزالة صلاحية مدير المنصة من حسابك الحالي');
        }

        $user->removeRole($role->name);

        return back()->with('success', 'تم سحب الصلاحية من المستخدم بنجاح');
    }
}
