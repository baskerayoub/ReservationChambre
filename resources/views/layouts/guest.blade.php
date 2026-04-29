<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Family Hotel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-950 relative overflow-hidden">
            <!-- Background decorations -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-blue-600/20 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-blue-400/10 blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-96 w-96 rounded-full bg-blue-500/5 blur-3xl"></div>
            </div>

            <!-- Logo -->
            <div class="relative z-10 animate-fade-in">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm transition-all duration-300 group-hover:scale-110 group-hover:bg-white/20">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight">Family Hotel</span>
                </a>
            </div>

            <!-- Content Card -->
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-8 bg-white/95 backdrop-blur-md shadow-2xl shadow-blue-950/30 rounded-2xl ring-1 ring-white/20 animate-fade-in-up">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="relative z-10 mt-8 mb-6 text-sm text-blue-200/60">&copy; {{ date('Y') }} Family Hotel</p>
        </div>
    </body>
</html>
