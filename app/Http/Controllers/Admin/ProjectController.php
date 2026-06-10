<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', ['items' => Project::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['item' => new Project]);
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['item' => $project]);
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request, $project));

        return redirect()->route('admin.projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        } $project->delete();

        return back()->with('status', 'Project deleted.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'], 'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'], 'url' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'max:3072'], 'color' => ['required', Rule::in(['blue', 'orange', 'green', 'purple'])],
            'sort_order' => ['required', 'integer'], 'is_published' => ['nullable', 'boolean'],
        ]);
        if ($request->hasFile('image_upload')) {
            if ($project?->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image_upload')->store('projects', 'public');
        }
        unset($data['image_upload']);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
