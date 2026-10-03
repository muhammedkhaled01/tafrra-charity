<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Beneficiary;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService)
    {
    }

    public function index()
    {
        $projects = Project::latest()->paginate(15);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->create($request->validated());
        return redirect()->route('projects.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load('beneficiaries');
        $allBeneficiaries = Beneficiary::select('id', 'name', 'national_id')->get();
        return view('projects.show', compact('project', 'allBeneficiaries'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->projectService->update($project, $request->validated());
        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function attachBeneficiaries(Request $request, Project $project)
    {
        $request->validate([
            'beneficiaries' => 'required|array',
            'beneficiaries.*' => 'exists:beneficiaries,id',
        ]);

        foreach ($request->beneficiaries as $beneficiaryId) {
            $beneficiary = Beneficiary::find($beneficiaryId);
            if($beneficiary) {
                $this->projectService->attachBeneficiary($project, $beneficiary, 'pending');
            }
        }
        
        return back()->with('success', 'تم إضافة المستفيدين للمشروع بنجاح.');
    }

    public function updateBeneficiaryStatus(Request $request, Project $project, Beneficiary $beneficiary)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $this->projectService->updateBeneficiaryStatus($project, $beneficiary, $request->status);

        return back()->with('success', 'Beneficiary status updated successfully.');
    }
}
