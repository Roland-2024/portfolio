<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile', ['profile' => PortfolioProfile::firstOrFail()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = PortfolioProfile::firstOrFail();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'upwork_url' => ['nullable', 'url', 'max:255'],
            'intro' => ['nullable', 'string', 'max:2000'],
            'bio' => ['required', 'string', 'max:5000'],
            'secondary_bio' => ['nullable', 'string', 'max:5000'],
            'profile_image_upload' => ['nullable', 'image', 'max:3072'],
            'years_experience' => ['required', 'integer', 'min:0', 'max:99'],
            'full_stack_years' => ['required', 'integer', 'min:0', 'max:99'],
            'availability' => ['nullable', 'string', 'max:255'],
            'languages' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('profile_image_upload')) {
            $data['profile_image'] = $request->file('profile_image_upload')->store('profile', 'public');
        }
        unset($data['profile_image_upload']);
        $profile->update($data);

        return back()->with('status', 'Profile updated.');
    }
}
