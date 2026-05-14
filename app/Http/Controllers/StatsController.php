<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;
use App\Models\HabitLog;
use App\Services\AchievementService;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // total complété
        $totalCompleted = HabitLog::whereHas('habit', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('completed', true)->count();

        // total possible (nb habitudes * nb jours)
        $totalHabits = $user->habits()->count();

        $daysTracked = HabitLog::whereHas('habit', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->distinct('date')->count('date');

        $totalPossible = $totalHabits * max($daysTracked, 1);

        // taux de réussite
        $successRate = $totalPossible > 0
            ? round(($totalCompleted / $totalPossible) * 100, 1)
            : 0;

        // données pour graphique (7 derniers jours)
        $last7Days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();

            $count = HabitLog::whereHas('habit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('date', $date)
            ->where('completed', true)
            ->count();

            $last7Days->push([
                'date' => $date,
                'count' => $count
            ]);
        }
        // donnée pour calendrier (30 jours) 
        $calendar = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();

            $count = HabitLog::whereHas('habit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('date', $date)
            ->where('completed', true)
            ->count();

            $calendar[] = [
                'date' => $date,
                'count' => $count
            ];
        }

        $showAchievements = $user->plan !== 'free';
        $achievements = [];
        $unlocked = [];

        if ($showAchievements) {
            $achievementService = new AchievementService();
            $achievementService->syncDefinitions();

            $achievements = Achievement::all();
            $unlocked = $user->achievements()->pluck('achievement_id')->toArray();
        }

        return view('stats.index', compact(
            'totalCompleted',
            'successRate',
            'last7Days',
            'calendar',
            'achievements',
            'unlocked',
            'showAchievements'
        ));
    }
}