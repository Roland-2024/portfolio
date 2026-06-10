<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        return view('admin.skills.index', ['items' => Skill::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.skills.form', ['item' => new Skill]);
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.form', ['item' => $skill]);
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::create($this->validated($request));

        return redirect()->route('admin.skills.index')->with('status', 'Skill created.');
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($this->validated($request, $skill));

        return redirect()->route('admin.skills.index')->with('status', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return back()->with('status', 'Skill deleted.');
    }

    private function validated(Request $request, ?Skill $skill = null): array
    {
        return $request->validate([
            'category' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100', Rule::unique('skills')->where(fn ($query) => $query->where('category', $request->input('category')))->ignore($skill)],
            'sort_order' => ['required', 'integer'],
        ]);
    }
}
