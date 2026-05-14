<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Achievement;
use App\Models\Habit;
use App\Models\Subscription;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Habit[] $habits
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function habits()
    {
        return $this->hasMany(Habit::class);
    }
    //
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }

    // Return the subscription status of the user
    public function getSubscriptionStatusAttribute()
    {
        return $this->subscription?->status ?? $this->subscription_status;
    }
    // return the subscription plan of the user
    public function getPlanAttribute(){
        return $this->subscription?->plan ?? 'free';
    }
}
