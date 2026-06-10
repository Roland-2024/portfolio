<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', ['items' => Experience::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.experiences.form', ['item' => new Experience]);
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.form', ['item' => $experience]);
    }

    public function store(Request $request): RedirectResponse
    {
        Experience::create($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Experience created.');
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Experience updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return back()->with('status', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:255'], 'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'], 'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'], 'description' => ['required', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer'], 'is_current' => ['nullable', 'boolean'],
        ]) + ['is_current' => $request->boolean('is_current')];
    }
}
