<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Achievements</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Gagnez des récompenses en atteignant vos objectifs.</p>
                    </div>
                    <a href="{{ route('stats.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 transition">Retour aux stats</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php $unlockedIds = is_array($unlocked) ? $unlocked : []; @endphp
                    @foreach($achievements as $achievement)
                        @php
                            $isUnlocked = in_array($achievement->id, $unlockedIds);
                        @endphp
                        <div class="rounded-lg border p-5 shadow-sm {{ $isUnlocked ? 'border-green-300 bg-green-50 dark:border-green-700 dark:bg-green-900' : 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800' }}">
                            <div class="flex items-center justify-between gap-4 mb-3">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $achievement->name }}</h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ $achievement->description }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $isUnlocked ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ $isUnlocked ? 'Débloqué' : 'Bloqué' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
