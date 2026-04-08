<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="inline-flex rounded-full bg-green-100 text-green-800 px-3 py-1 text-sm font-semibold dark:bg-green-900/40 dark:text-green-200">Nouveau</p>
                    <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                        Bienvenue sur <span class="text-indigo-600 dark:text-indigo-400">HabitFlow</span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Transformez vos routines en habitudes durables. Suivez vos succès quotidiens, améliorez vos streaks et gardez votre motivation chaque jour.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('habits.index') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                Gérer mes habitudes
                            </a>
                            <a href="{{ route('stats.index') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-white px-6 py-3 text-base font-semibold text-indigo-700 shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700 transition">
                                Voir mes stats
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                Se connecter
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-white px-6 py-3 text-base font-semibold text-indigo-700 shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700 transition">
                                    Créer un compte
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Votre tableau de bord</h2>
                    <ul role="list" class="mt-4 space-y-3 text-gray-600 dark:text-gray-300">
                        <li class="flex gap-2"><span class="text-green-600 dark:text-green-400">✔</span> Logging quotidien rapide</li>
                        <li class="flex gap-2"><span class="text-green-600 dark:text-green-400">✔</span> Calcul automatique de streaks et meilleures performances</li>
                        <li class="flex gap-2"><span class="text-green-600 dark:text-green-400">✔</span> Visualisation par calendrier et historique 7/30 jours</li>
                        <li class="flex gap-2"><span class="text-green-600 dark:text-green-400">✔</span> Edition et suppression d’habitudes</li>
                    </ul>
                </div>
            </div>
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-300">Utilisateurs</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $users ?? 0  }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-300">Habits complété aujourd’hui</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $todayCompleted ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-300">Meilleur streak</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $bestStreak ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-300">Taux réussite</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $successRate ?? 0 }}%</p>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
