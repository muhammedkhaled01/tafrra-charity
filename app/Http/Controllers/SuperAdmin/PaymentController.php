<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::enum(PaymentStatus::class)],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $payments = Payment::with(['tenant', 'subscription'])
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, fn ($query, string $search) => $query->where(function ($query) use ($search): void {
                $query->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('tenant', fn ($tenantQuery) => $tenantQuery->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totals = Payment::selectRaw('status, count(*) as count, sum(amount) as amount')
            ->groupBy('status')
            ->get()
            ->keyBy(fn (Payment $row): string => $row->status->value);

        return view('super-admin.payments.index', compact('payments', 'totals', 'filters'));
    }
}
