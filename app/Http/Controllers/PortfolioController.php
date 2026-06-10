<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $profile = PortfolioProfile::firstOrFail();

        return view('portfolio', [
            'profile' => $profile,
            'skills' => Skill::orderBy('sort_order')->get()->groupBy('category'),
            'experiences' => Experience::orderBy('sort_order')->get(),
            'education' => Education::orderBy('sort_order')->get(),
            'projects' => Project::where('is_published', true)->orderBy('sort_order')->get(),
            'socialLinks' => SocialLink::where('is_visible', true)->orderBy('sort_order')->get(),
        ]);
    }
}
