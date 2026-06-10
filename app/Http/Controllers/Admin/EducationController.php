<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function index(): View
    {
        return view('admin.education.index', ['items' => Education::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.education.form', ['item' => new Education]);
    }

    public function edit(Education $education): View
    {
        return view('admin.education.form', ['item' => $education]);
    }

    public function store(Request $request): RedirectResponse
    {
        Education::create($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Education created.');
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $education->update($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Education updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return back()->with('status', 'Education deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'qualification' => ['required', 'string', 'max:255'], 'institution' => ['required', 'string', 'max:255'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'], 'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string', 'max:3000'], 'sort_order' => ['required', 'integer'],
        ]);
    }
}
