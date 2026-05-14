<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentPlan = $user->plan;

        return view('subscription.index', compact('currentPlan'));
    }

    public function upgrade(Request $request)
    {
        $user = Auth::user();

        if ($user->plan === 'premium') {
            return redirect()->route('subscription.index')->with('success', 'Vous êtes déjà en premium.');
        }

        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            ['plan' => 'premium', 'status' => 'active']
        );

        return redirect()->route('subscription.index')->with('success', 'Votre abonnement premium a bien été activé.');
    }
}
