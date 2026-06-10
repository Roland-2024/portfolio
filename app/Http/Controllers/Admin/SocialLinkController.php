<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.social-links.index', ['items' => SocialLink::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.social-links.form', ['item' => new SocialLink]);
    }

    public function edit(SocialLink $social_link): View
    {
        return view('admin.social-links.form', ['item' => $social_link]);
    }

    public function store(Request $request): RedirectResponse
    {
        SocialLink::create($this->validated($request));

        return redirect()->route('admin.social-links.index')->with('status', 'Social link created.');
    }

    public function update(Request $request, SocialLink $social_link): RedirectResponse
    {
        $social_link->update($this->validated($request, $social_link));

        return redirect()->route('admin.social-links.index')->with('status', 'Social link updated.');
    }

    public function destroy(SocialLink $social_link): RedirectResponse
    {
        $social_link->delete();

        return back()->with('status', 'Social link deleted.');
    }

    private function validated(Request $request, ?SocialLink $socialLink = null): array
    {
        $data = $request->validate([
            'platform' => ['required', 'string', 'max:100', Rule::unique('social_links')->ignore($socialLink)],
            'label' => ['required', 'string', 'max:100'], 'url' => ['required', 'string', 'max:500'],
            'sort_order' => ['required', 'integer'], 'is_visible' => ['nullable', 'boolean'],
        ]);
        $data['is_visible'] = $request->boolean('is_visible');

        return $data;
    }
}
