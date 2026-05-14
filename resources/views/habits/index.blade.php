<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @php
                    $userPlan = Auth::user()->plan ?? 'free';
                    $habitLimit = $userPlan === 'premium' ? 30 : 5;
                    $canAddHabit = $habits->count() < $habitLimit;
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Mes habitudes</h1>
                    @if ($canAddHabit)
                        <a href="{{ route('habits.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 transition">Ajouter une habitude</a>
                    @else
                        <span class="inline-flex items-center justify-center rounded-md bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Limite du plan atteinte</span>
                    @endif
                </div>

                @if (session('achievements'))
                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-900 dark:border-green-700 dark:bg-green-900 dark:text-green-100">
                        <strong>Félicitations !</strong> Vous avez débloqué : {{ implode(', ', session('achievements')) }}
                    </div>
                @endif

                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    
                    @if ($habits->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-300 col-span-full">Aucune habitude trouvée. Commencez par en ajouter une !</p>
                    @endif

                    @foreach ($habits as $habit)
                        <li class="col-span-1 rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                            @php
                                $today = \Carbon\Carbon::today()->toDateString();
                                $todayLog = $habit->logs->where('date', $today)->where('completed', true)->first();
                            @endphp
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $habit->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-300 truncate">{{ $habit->description }}</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold dark:bg-green-900 dark:text-green-200">{{ $todayLog ? '✅ Complété' : '❌ Non complété' }}</span>
                                </div>
                                <div class="mt-4 text-sm text-gray-700 dark:text-gray-200 space-y-1">
                                    <p>Streak : <span class="font-semibold">{{ $habit->currentStreak() }} jours</span></p>
                                    <p>Best streak : <span class="font-semibold">{{ $habit->bestStreak() }} jours</span></p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 p-3 flex gap-2">
                                <form method="POST" action="{{ route('habits.complete', $habit->id) }}" class="flex-1">
                                    @csrf
                                    <button class="w-full rounded-md bg-green-500 px-2 py-2 text-xs font-semibold text-white hover:bg-green-600 transition">DONE</button>
                                </form>
                                <a href="{{ route('habits.edit', $habit->id) }}" class="flex-1 rounded-md bg-blue-500 px-2 py-2 text-center text-xs font-semibold text-white hover:bg-blue-600 transition">Modifier</a>
                                <form action="{{ route('habits.destroy', $habit->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full rounded-md bg-red-500 px-2 py-2 text-xs font-semibold text-white hover:bg-red-600 transition" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette habitude ?')">Supprimer</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                    @php
                        $userPlan = Auth::user()->getPlanAttribute() ?? 'free';
                        $habitLimit = $userPlan === 'premium' ? 30 : 5;
                        $canAddHabit = $habits->count() < $habitLimit;
                    @endphp

                    @if ($canAddHabit)
                        <li class="col-span-1 rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">Ajouter une habitude</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-300 truncate"></p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold dark:bg-green-900 dark:text-green-200">Nouveau</span>
                                </div>
                                <div class="mt-4 text-sm text-gray-700 dark:text-gray-200 space-y-1">
                                    <p>Vous pouvez ajouter {{ $habitLimit - $habits->count() }} habitude(s) de plus sur votre plan {{ $userPlan }}.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 p-3 flex gap-2">
                                <a href="{{ route('habits.create') }}" class="flex-1 rounded-md bg-blue-500 px-2 py-2 text-center text-xs font-semibold text-white hover:bg-blue-600 transition">Ajouter une habitude</a>
                            </div>
                        </li>
                    @endif

                    @if ($userPlan === 'free' && ! $canAddHabit)
                        <li class="col-span-1 rounded-lg bg-gray-50 dark:bg-gray-700 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">Passez premium</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-300 truncate"></p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold dark:bg-green-900 dark:text-green-200">Upgrade</span>
                                </div>
                                <div class="mt-4 text-sm text-gray-700 dark:text-gray-200 space-y-1">
                                    <p>Vous avez atteint la limite de 5 habitudes. Passez premium pour en ajouter plus.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 p-3 flex gap-2">
                                <a href="{{ route('subscription.index') }}" class="flex-1 rounded-md bg-blue-500 px-2 py-2 text-center text-xs font-semibold text-white hover:bg-blue-600 transition">Passer premium</a>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</x-app-layout>