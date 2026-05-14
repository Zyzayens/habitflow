<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WelcomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Landing page 
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');
// Habits
    Route::resource('habits', HabitController::class)->middleware('auth');
//Complete habit
    Route::post('/habits/{id}/complete', [HabitController::class, 'complete'])
        ->Middleware(['auth'])
        ->name('habits.complete');
    Route::get('/stats', [StatsController::class,'index'])
        ->middleware('auth')
        ->name('stats.index');
    Route::get('/achievements', [AchievementController::class, 'index'])
        ->middleware('auth')
        ->name('achievements.index');
    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->middleware('auth')
        ->name('subscription.index');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])
        ->middleware('auth')
        ->name('subscription.upgrade');
// Profile
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
