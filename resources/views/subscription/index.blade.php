<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Abonnement</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Plan actuel : <span class="font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($currentPlan) }}</span></p>
                    </div>
                    <a href="{{ route('habits.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 transition">Retour aux habitudes</a>
                </div>

                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900 dark:text-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Plan gratuit</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Jusqu'à 5 habitudes. Idéal pour démarrer et tester vos routines.</p>
                        <ul class="mt-3 list-disc pl-5 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>Suivi illimité de complétion</li>
                            <li>Streaks et meilleures performances</li>
                        </ul>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-6 dark:border-blue-800 dark:bg-blue-900">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Plan premium</h2>
                                <p class="mt-2 text-sm text-blue-800 dark:text-blue-200">Profitez de 30 habitudes, plus de flexibilité et un suivi plus complet.</p>
                            </div>
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-800 dark:text-blue-100">Premium</span>
                        </div>

                        <ul class="mt-3 list-disc pl-5 text-sm text-blue-800 dark:text-blue-200 space-y-1">
                            <li>Jusqu'à 30 habits</li>
                            <li>Priorité sur les fonctionnalités futures</li>
                            <li>Accès complet au suivi</li>
                            <li>Débloquez des achievements exclusifs</li>
                        </ul>

                        @if ($currentPlan !== 'premium')
                            <form action="{{ route('subscription.upgrade') }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">Passer premium</button>
                            </form>
                        @else
                            <div class="mt-6 rounded-md bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900 dark:text-green-100">Vous êtes déjà en premium.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
