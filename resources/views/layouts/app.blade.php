<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                <main class="max-w-5xl mx-auto py-8 px-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
    <footer>
        <script>
            function toggleDarkMode() {
                document.documentElement.classList.toggle('dark');

                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');

                // Update toggle checkbox
                const toggle = document.getElementById('darkModeToggle');
                if (toggle) toggle.checked = isDark;
            }

            // Load user preference
            const savedTheme = localStorage.getItem('theme');
            const isDark = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            }

            // Set initial state
            document.addEventListener('DOMContentLoaded', function() {
                const toggle = document.getElementById('darkModeToggle');
                if (toggle) toggle.checked = isDark;
            });
        </script>
    </footer>
</html>
