<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;
use App\Services\AchievementService;

class AchievementController extends Controller
{
    public function index(AchievementService $achievementService)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->plan === 'free') {
            return redirect()->route('subscription.index')->with('error', 'Les achievements sont réservés aux abonnés premium.');
        }

        $achievementService->syncDefinitions();

        $achievements = Achievement::all();
        $unlocked = $user->achievements()->pluck('achievement_id')->toArray();

        return view('achievements.index', compact('achievements', 'unlocked'));
    }
}
