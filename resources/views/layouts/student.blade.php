<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Siswa - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts') <!-- Untuk script tambahan per halaman -->
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="text-xl font-semibold text-gray-700">
                        <a href="{{ route('siswa.dashboard') }}" class="text-gray-800 hover:text-gray-700">{{ config('app.name', 'Laravel') }}</a>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('siswa.dashboard') }}" class="px-3 py-2 text-gray-700 hover:underline">Dashboard</a>
                        <a href="{{ route('siswa.packages.index') }}" class="px-3 py-2 text-gray-700 hover:underline">Paket Belajar</a>
                        <!-- User Dropdown -->
                        <div class="relative">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="ml-4 text-sm text-gray-600 hover:text-gray-900 underline">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="container mx-auto px-6">
                 <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
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
