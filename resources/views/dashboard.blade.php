<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Tableau de bord</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 max-w-2xl">Suivez vos habitudes, consultez vos performances et passez premium pour lever vos limites.</p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <a href="{{ route('habits.index') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Mes habitudes</a>
                <a href="{{ route('stats.index') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">Voir mes stats</a>
            </div>
        </div>
    </x-slot>

    @php
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $plan = $user->plan ?? 'free';
        $habitsCount = $user->habits()->count();
        $maxHabits = $plan === 'premium' ? 30 : 5;
        $remaining = max($maxHabits - $habitsCount, 0);
        $today = \Carbon\Carbon::today()->toDateString();
        $todayCompletedHabitIds = \App\Models\HabitLog::whereHas('habit', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('date', $today)->where('completed', true)->pluck('habit_id')->toArray();
        $nextHabits = $user->habits()->whereNotIn('id', $todayCompletedHabitIds)->get();
        $recentActivities = \App\Models\HabitLog::whereHas('habit', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('completed', true)->with('habit')->orderBy('date', 'desc')->take(5)->get();
        $achievementCount = $plan !== 'free' ? $user->achievements()->count() : 0;
        $achievementTotal = $plan !== 'free' ? \App\Models\Achievement::count() : 0;
        $achievementProgress = $achievementTotal > 0 ? round($achievementCount / $achievementTotal * 100) : 0;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-400">Habitudes</p>
                            <h3 class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">{{ $habitsCount }}</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Habitude{{ $habitsCount > 1 ? 's' : '' }} actives sur votre compte.</p>
                        </div>
                        <div class="rounded-full bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">Plan {{ ucfirst($plan) }}</div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Limite du plan</p>
                            <p class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $maxHabits }} habitudes</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Places restantes</p>
                            <p class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $remaining }}</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-dashed border-gray-200 bg-slate-50 p-5 text-sm text-gray-700 dark:border-gray-700 dark:bg-slate-900 dark:text-gray-300">
                        <p class="font-semibold">Conseil rapide</p>
                        <p class="mt-2">Ajoutez des habitudes régulières et suivez-les tous les jours pour améliorer votre constance. Plus vous créez de routines, plus vous progressez.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl bg-gradient-to-br from-slate-900 to-indigo-700 p-6 text-white shadow-sm">
                        <p class="text-sm uppercase tracking-wide text-slate-300">Le plan premium débloque plus de puissance</p>
                        <h3 class="mt-3 text-2xl font-bold">Jusqu'à 30 habitudes</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-200">Passez premium pour supprimer la limite de 5 habitudes, débloquer tous les achievements et profiter d'un suivi plus souple.</p>
                        @if ($plan === 'free')
                            <a href="{{ route('subscription.index') }}" class="mt-6 inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-indigo-900 shadow-sm hover:bg-slate-100 transition">Passer premium</a>
                        @else
                            <span class="mt-6 inline-flex items-center rounded-md bg-white/10 px-3 py-1 text-sm font-semibold text-slate-100">Vous êtes premium</span>
                        @endif
                    </div>

                    <div class="grid gap-4">
                        <a href="{{ route('habits.index') }}" class="block rounded-xl border border-gray-200 bg-white px-5 py-6 text-left shadow-sm transition hover:border-indigo-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Gérer mes habitudes</p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Créer, modifier et supprimer vos routines.</p>
                        </a>
                        <a href="{{ route('stats.index') }}" class="block rounded-xl border border-gray-200 bg-white px-5 py-6 text-left shadow-sm transition hover:border-emerald-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Voir mes statistiques</p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Suivre vos progrès quotidiens et mensuels.</p>
                        </a>
                        @if ($plan !== 'free')
                            <a href="{{ route('achievements.index') }}" class="block rounded-xl border border-gray-200 bg-white px-5 py-6 text-left shadow-sm transition hover:border-amber-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Mes achievements</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Consultez vos récompenses et objectifs débloqués.</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Prochaine action</p>
                    @if ($nextHabits->isEmpty())
                        <p class="mt-3 text-sm text-gray-700 dark:text-gray-300">Toutes les habitudes du jour sont complétées. Continuez sur cette lancée !</p>
                    @else
                        <ul class="mt-3 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            @foreach($nextHabits->take(3) as $nextHabit)
                                <li class="rounded-md bg-gray-50 px-3 py-2 dark:bg-gray-900">{{ $nextHabit->name }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">{{ $nextHabits->count() }} action(s) restante(s) aujourd'hui</p>
                    @endif
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dernières activités</p>
                    @if ($recentActivities->isEmpty())
                        <p class="mt-3 text-sm text-gray-700 dark:text-gray-300">Aucune activité récente. Commencez par compléter votre première habitude.</p>
                    @else
                        <ul class="mt-3 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            @foreach($recentActivities as $activity)
                                <li class="rounded-md bg-gray-50 px-3 py-2 dark:bg-gray-900">
                                    <span class="font-semibold">{{ $activity->habit->name }}</span> — {{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M') }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Résumé des achievements</p>
                            <h3 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ $plan === 'free' ? 'Premium requis' : $achievementCount . ' / ' . $achievementTotal }}</h3>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase text-slate-600 dark:bg-slate-700 dark:text-slate-300">{{ $plan === 'free' ? 'Free' : $achievementProgress . '%' }}</span>
                    </div>

                    @if ($plan === 'free')
                        <p class="mt-4 text-sm text-gray-700 dark:text-gray-300">Débloquez tous les achievements, accédez à des objectifs premium et appréciez un suivi plus motivant.</p>
                        <div class="mt-5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 w-1/4 bg-gradient-to-r from-indigo-500 to-sky-500"></div>
                        </div>
                        <a href="{{ route('subscription.index') }}" class="mt-5 inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">Passer premium</a>
                    @else
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Progression globale de vos achievements débloqués.</p>
                        <div class="mt-5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $achievementProgress }}%;"></div>
                        </div>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl border border-gray-200 bg-slate-50 p-3 text-sm text-slate-700 dark:border-gray-700 dark:bg-slate-900 dark:text-slate-300">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $achievementProgress }}%</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Objectif général</p>
                            </div>
                            <div class="rounded-xl border border-gray-200 bg-slate-50 p-3 text-sm text-slate-700 dark:border-gray-700 dark:bg-slate-900 dark:text-slate-300">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $achievementCount }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Débloqués</p>
                            </div>
                        </div>
                        <a href="{{ route('achievements.index') }}" class="mt-5 inline-flex items-center rounded-md bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600 transition">Voir mes achievements</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
