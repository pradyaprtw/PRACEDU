
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar - PRACEDU</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex w-full max-w-5xl m-4 bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Kolom Kiri - Branding -->
            <div class="hidden md:flex w-1/2 bg-blue-600 p-12 flex-col justify-between">
                <div>
                    <h1 class="text-white text-3xl font-bold">PRACEDU</h1>
                    <p class="text-blue-200 mt-2">Practice for Education</p>
                </div>
                <div>
                    <h2 class="text-white text-3xl font-bold leading-tight">Mulai Perjalanan Belajarmu.</h2>
                    <p class="text-blue-100 mt-4">Buat akun dan dapatkan akses ke ribuan materi dan soal latihan berkualitas untuk membantumu meraih impian.</p>
                </div>
                <div class="text-center text-blue-200 text-sm">
                    &copy; {{ date('Y') }} PRACEDU. All Rights Reserved.
                </div>
            </div>

            <!-- Kolom Kanan - Form Register -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
                <p class="text-gray-500 mb-8">Hanya butuh beberapa detik.</p>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input id="email" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input id="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-transform transform hover:scale-105">
                            Daftar
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>