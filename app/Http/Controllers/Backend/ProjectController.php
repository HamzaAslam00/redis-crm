<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreProjectRequest;
use App\Http\Requests\Backend\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('backend.projects.index');
    }

    public function create(): View
    {
        return view('backend.projects.create', [
            'statuses' => Project::$statuses,
            'currencies' => Project::$currencies,
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create(array_merge(
            $request->validated(),
            ['project_code' => Project::generateCode()]
        ));

        return redirect()->route('admin.projects.show', $project)
            ->with('success', "Project {$project->project_code} created successfully.");
    }

    public function show(Project $project): View
    {
        $project->load(['documents.uploader', 'messages.user']);

        return view('backend.projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('backend.projects.edit', [
            'project' => $project,
            'statuses' => Project::$statuses,
            'currencies' => Project::$currencies,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', "Project {$project->project_code} deleted.");
    }
}
