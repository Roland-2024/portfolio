<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Projects' => Project::count(),
                'Skills' => Skill::count(),
                'Experience entries' => Experience::count(),
                'Unread messages' => ContactMessage::where('is_read', false)->count(),
            ],
            'messages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
