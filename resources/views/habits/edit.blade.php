<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Modifier l’habitude</h1>

                <form method="POST" action="{{ route('habits.update', $habit->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom</label>
                        <input id="name" type="text" name="name" value="{{ $habit->name }}" placeholder="Nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Description" required>{{ $habit->description }}</textarea>
                    </div>

                    <fieldset class="space-y-2">
                        <legend class="block text-sm font-medium text-gray-700 dark:text-gray-200">Fréquence</legend>
                        <div class="flex gap-4 flex-wrap">
                            @foreach(['Daily','Weekly','Monthly','Yearly'] as $freq)
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                                    <input type="radio" name="frequency" value="{{ $freq }}" {{ $habit->frequency === $freq ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500" required>
                                    {{ $freq }}
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <button type="submit" class="w-full rounded-md bg-blue-500 px-4 py-2 text-white font-semibold hover:bg-blue-600 transition">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>