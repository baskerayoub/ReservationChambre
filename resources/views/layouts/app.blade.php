<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Hotelia — Premium Family Hotel Reservations')">

    <title>@yield('title', 'Hotelia') — Premium Family Hotel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Heroicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 dark:bg-gray-900/80 border-b border-gray-200/50 dark:border-gray-700/50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:shadow-amber-500/40 transition-shadow">
                        <i class="fas fa-hotel text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-amber-500 to-orange-500 bg-clip-text text-transparent">Hotelia</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('home') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10' : '' }}">Home</a>
                    <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('rooms.*') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10' : '' }}">Rooms</a>

                    @auth
                        <a href="{{ route('reservations.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('reservations.*') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10' : '' }}">My Reservations</a>

                        @if(auth()->user()->isStaff())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.*') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10' : '' }}">
                                <i class="fas fa-gauge-high mr-1"></i> Dashboard
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-2">
                    {{-- Dark Mode Toggle --}}
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Toggle dark mode">
                        <i x-show="!darkMode" class="fas fa-moon text-gray-500"></i>
                        <i x-show="darkMode" class="fas fa-sun text-amber-400" style="display:none"></i>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all">Book Now</a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50" style="display: none;">
                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-user-gear w-4 text-gray-400"></i> Profile Settings</a>
                                <a href="{{ route('reservations.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-calendar-check w-4 text-gray-400"></i> My Reservations</a>
                                <div class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors"><i class="fas fa-right-from-bracket w-4"></i> Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-transition class="md:hidden pb-4" style="display:none">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Home</a>
                    <a href="{{ route('rooms.index') }}" class="px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Rooms</a>
                    @auth
                        <a href="{{ route('reservations.index') }}" class="px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800">My Reservations</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success') || session('error') || session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <span class="text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto"><i class="fas fa-times"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <span class="text-sm">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto"><i class="fas fa-times"></i></button>
                </div>
            @endif
            @if(session('info'))
                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 text-blue-700 dark:text-blue-400 flex items-center gap-3">
                    <i class="fas fa-info-circle"></i>
                    <span class="text-sm">{{ session('info') }}</span>
                    <button @click="show = false" class="ml-auto"><i class="fas fa-times"></i></button>
                </div>
            @endif
        </div>
    @endif

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @hasSection('hide_footer')
    @else
    <footer class="bg-gray-900 dark:bg-gray-950 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center"><i class="fas fa-hotel text-white text-sm"></i></div>
                        <span class="text-xl font-bold text-white">Hotelia</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">A premium family hotel offering unforgettable experiences in an atmosphere of luxury and comfort.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-amber-400 transition-colors">Our Rooms</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Contact</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li><i class="fas fa-utensils w-4 text-amber-400"></i> Restaurant & Bar</li>
                        <li><i class="fas fa-spa w-4 text-amber-400"></i> Spa & Wellness</li>
                        <li><i class="fas fa-swimmer w-4 text-amber-400"></i> Swimming Pool</li>
                        <li><i class="fas fa-shuttle-van w-4 text-amber-400"></i> Airport Shuttle</li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt w-4 text-amber-400"></i> 123 Ocean Drive, Paradise City</li>
                        <li class="flex items-center gap-2"><i class="fas fa-phone w-4 text-amber-400"></i> +1 (555) 123-4567</li>
                        <li class="flex items-center gap-2"><i class="fas fa-envelope w-4 text-amber-400"></i> info@hotelia.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Hotelia. All rights reserved.
            </div>
        </div>
    </footer>
    @endif

    {{-- AI Chat Widget --}}
    @auth
    <div x-data="chatWidget()" class="fixed bottom-6 right-6 z-50">
        {{-- Chat Window --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90 translate-y-4" class="mb-4 w-[380px] max-h-[500px] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden" style="display:none">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center"><i class="fas fa-robot text-white"></i></div>
                    <div>
                        <h3 class="text-white font-semibold text-sm">Hotelia Assistant</h3>
                        <p class="text-white/70 text-xs">AI-powered concierge</p>
                    </div>
                </div>
                <button @click="open = false" class="text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            {{-- Messages --}}
            <div x-ref="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-[300px] max-h-[350px]">
                <template x-for="msg in messages" :key="msg.id">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="msg.role === 'user' ? 'bg-amber-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-2xl rounded-bl-md'" class="max-w-[80%] px-4 py-2.5 text-sm leading-relaxed" x-text="msg.content"></div>
                    </div>
                </template>
                <div x-show="loading" class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-bl-md px-4 py-3">
                        <div class="flex gap-1.5">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Input --}}
            <form @submit.prevent="send()" class="p-3 border-t border-gray-200 dark:border-gray-700 flex items-center gap-2">
                <input x-model="input" type="text" placeholder="Ask about our rooms..." class="flex-1 px-4 py-2.5 text-sm bg-gray-100 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-amber-500 dark:text-white placeholder-gray-400" :disabled="loading" />
                <button type="submit" :disabled="loading || !input.trim()" class="p-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl hover:opacity-90 disabled:opacity-40 transition-opacity"><i class="fas fa-paper-plane text-sm"></i></button>
            </form>
        </div>

        {{-- Toggle Button --}}
        <button @click="open = !open" class="w-14 h-14 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full shadow-xl shadow-amber-500/30 flex items-center justify-center text-white hover:shadow-amber-500/50 transition-all hover:scale-105 active:scale-95">
            <i x-show="!open" class="fas fa-comments text-xl"></i>
            <i x-show="open" class="fas fa-times text-xl" style="display:none"></i>
        </button>
    </div>
    @endauth

    @stack('scripts')

    <script>
        function chatWidget() {
            return {
                open: false,
                loading: false,
                input: '',
                sessionId: null,
                messages: [
                    { id: 0, role: 'assistant', content: 'Welcome to Hotelia! 👋 How can I help you today? Ask me about our rooms, services, or make a reservation.' }
                ],
                async send() {
                    if (!this.input.trim() || this.loading) return;
                    const text = this.input.trim();
                    this.input = '';
                    this.messages.push({ id: Date.now(), role: 'user', content: text });
                    this.loading = true;
                    this.$nextTick(() => this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight);

                    try {
                        const res = await fetch('{{ route("chatbot.send") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ message: text, session_id: this.sessionId })
                        });
                        const data = await res.json();
                        this.sessionId = data.session_id;
                        this.messages.push({ id: Date.now() + 1, role: 'assistant', content: data.reply });
                    } catch {
                        this.messages.push({ id: Date.now() + 1, role: 'assistant', content: 'Sorry, I encountered an error. Please try again.' });
                    }
                    this.loading = false;
                    this.$nextTick(() => this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight);
                }
            };
        }
    </script>
</body>
</html>
