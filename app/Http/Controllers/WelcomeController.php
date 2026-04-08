<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;

class WelcomeController extends Controller
{
    public function index()
    {
        $users = User::count();
        $today = Carbon::today()->toDateString();
        $todayCompleted = HabitLog::where('date', $today)->where('completed', true)->count();
        $bestStreak = Habit::all()->max(function ($habit) {
            return $habit->bestStreak();
        }) ?? 0;
        $totalLogs = HabitLog::count();
        $completedLogs = HabitLog::where('completed', true)->count();
        $successRate = $totalLogs > 0 ? round(($completedLogs / $totalLogs) * 100) : 0;

        return view('welcome', compact('users', 'todayCompleted', 'bestStreak', 'successRate'));
    }
}
