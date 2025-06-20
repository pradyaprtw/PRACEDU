<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Siswa - PRACEDU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="text-xl font-semibold text-gray-700">
                        <a href="{{ route('siswa.dashboard') }}" class="text-gray-800 hover:text-gray-700">PRACEDU</a>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('siswa.dashboard') }}" class="px-3 py-2 text-gray-700 hover:underline">Dashboard</a>
                        <a href="{{ route('siswa.tryout.packages') }}" class="px-3 py-2 text-gray-700 hover:underline">Try Out</a>
                        <a href="{{ route('siswa.packages.index') }}" class="px-3 py-2 text-gray-700 hover:underline">Paket Belajar</a>
                        
                        <!-- User Dropdown (BARU) -->
                        <div x-data="{ open: false }" class="relative ml-4">
                            <button @click="open = !open" class="flex items-center text-gray-700 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-md shadow-xl z-20">
                                <a href="{{ route('siswa.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">
                                    Edit Profil
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="container mx-auto px-6">
                 @if (session('status') === 'profil-updated')
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>Profil berhasil diperbarui!</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
