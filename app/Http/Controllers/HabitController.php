<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use App\Models\HabitLog;
use App\Services\AchievementService;
use Carbon\Carbon;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habits = Habit::with('logs')->where('user_id', auth()->id())->get();
        return view('habits.index', compact('habits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('habits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:1000',
            'frequency'=>'required|string|max:255',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userPlan = $user->plan;
        if ($userPlan == 'free') {
            $userHabitsCount = $user->habits()->count();
            if ($userHabitsCount >= 5) {
                return redirect()->back()
                    ->withErrors(['limit' => 'Trop d\'habitudes. Passez au plan premium pour en ajouter plus.'])
                    ->withInput();
            }
        }
        $user->habits()->create($request->only('name', 'description', 'frequency'));

        $awarded = (new AchievementService())->check($user);

        return redirect()->route('habits.index')
            ->with('achievements', collect($awarded)->pluck('name')->toArray());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $habit = Habit ::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
        return view ('habits.edit', compact ('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'frequency'=>'required|string|max:255',
    ]);

    $habit = Habit::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $habit->update($request->only('name', 'description', 'frequency'));

    return redirect()->route('habits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $habit = Habit::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
        $habit->delete();
        return redirect()->route('habits.index');

    }
    /**
     * Add the completion to the habit
     */
    public function complete($id)
    {
        $habit = Habit::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
        $today = Carbon::today();
        HabitLog::updateOrCreate(
            [
                'habit_id'=> $habit->id,
                'date'=> $today,
            ],
            ['completed'=>true]
        );

        $awarded = (new AchievementService())->check($habit->user);

        return redirect()->route('habits.index')
            ->with('achievements', collect($awarded)->pluck('name')->toArray());
    }
}
