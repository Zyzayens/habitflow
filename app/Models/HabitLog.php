<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Habit;
class HabitLog extends Model
{
    use HasFactory;
    public function habit(){
        return $this->belongsTo(Habit::class);
    }
protected $fillable = [
    'habit_id',
    'date',
    'completed'
];
}
