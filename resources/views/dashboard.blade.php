<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-lg font-medium mb-4">{{ __('Welcome to Habit Flow!') }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('habits.index') }}" class="block text-center bg-blue-500 text-white rounded-lg px-4 py-3 hover:bg-blue-600 transition">Vos habitudes</a>
                        <a href="{{ route('stats.index') }}" class="block text-center bg-emerald-500 text-white rounded-lg px-4 py-3 hover:bg-emerald-600 transition">Statistiques</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
