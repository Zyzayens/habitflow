<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HabitLog;
use Carbon\Carbon;
class Habit extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
        }
     public function logs(){
        return $this->hasMany(HabitLog::class);
    }
    
    // Get the logs then determine the current streak of a habit
    public function currentStreak()
    {
        $logs = $this->logs()
            ->where('completed', true)
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        $streak = 0;
        $today = Carbon::today();

        foreach ($logs as $date) {
            if (Carbon::parse($date)->isSameDay($today)) {
                $streak++;
                $today->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

// Get the logs then determine the best streak of a habit
    public function bestStreak()
    {
        $logs = $this->logs()
            ->where('completed', true)
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->toArray();

        $best = 0;
        $current = 0;
        $prevDate = null;

        foreach ($logs as $date) {
            $date = Carbon::parse($date);

            if ($prevDate && $date->diffInDays($prevDate) == 1) {
                $current++;
            } else {
                $current = 1;
            }

            $best = max($best, $current);
            $prevDate = $date;
        }

        return $best;
    }
    protected $fillable = [
        'name',
        'description',
        'frequency',
    ];
        

}

