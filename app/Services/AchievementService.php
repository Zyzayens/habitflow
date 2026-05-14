<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\HabitLog;
use App\Models\User;
use Carbon\Carbon;

class AchievementService
{
    public function syncDefinitions(): void
    {
        foreach (config('achievements.definitions', []) as $definition) {
            Achievement::updateOrCreate(
                ['slug' => $definition['slug']],
                $definition
            );
        }
    }

    public function check(User $user): array
    {
        $this->syncDefinitions();

        $awarded = [];

        foreach (Achievement::all() as $achievement) {
            if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                continue;
            }

            if ($this->passes($user, $achievement)) {
                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => Carbon::now(),
                ]);

                $awarded[] = $achievement;
            }
        }

        return $awarded;
    }

    protected function passes(User $user, Achievement $achievement): bool
    {
        return match ($achievement->type) {
            'plan_limit' => $this->passesPlanLimit($user),
            'monthly_consistency' => $this->passesMonthlyConsistency($user),
            default => false,
        };
    }

    protected function passesPlanLimit(User $user): bool
    {
        $limit = $user->plan === 'premium' ? 30 : 5;
        return $user->habits()->count() >= $limit;
    }

    protected function passesMonthlyConsistency(User $user): bool
    {
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();

            $hasCompleted = HabitLog::whereHas('habit', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('date', $date)
            ->where('completed', true)
            ->exists();

            if (! $hasCompleted) {
                return false;
            }
        }

        return true;
    }
}
