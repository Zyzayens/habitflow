<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">📊 Statistiques</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-500">Total complété</p>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalCompleted }}</h2>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                        <p class="text-sm text-gray-500">Taux de réussite</p>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $successRate }}%</h2>
                    </div>
                </div>

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">📅 Activité (30 jours)</h2>
                <div class="grid grid-cols-10 gap-1 mb-8">
                    @foreach($calendar as $day)
                        @php
                            $color = match(true) {
                                $day['count'] == 0 => 'bg-gray-300 dark:bg-gray-600',
                                $day['count'] == 1 => 'bg-green-200 dark:bg-green-500',
                                $day['count'] == 2 => 'bg-green-400 dark:bg-green-600',
                                default => 'bg-green-600 dark:bg-green-700',
                            };
                        @endphp

                        <div class="w-6 h-6 rounded-sm {{ $color }}" title="{{ $day['date'] }} : {{ $day['count'] }}"></div>
                    @endforeach
                </div>

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Activité (7 jours)</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                    @foreach($last7Days as $day)
                        <div class="flex justify-between border-b border-gray-200 dark:border-gray-600 py-2 text-sm text-gray-800 dark:text-gray-100">
                            <span>{{ $day['date'] }}</span>
                            <span>{{ $day['count'] }} complétées</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>