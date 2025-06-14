<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - PRACEDU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex w-full max-w-5xl m-4 bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Kolom Kiri - Branding -->
            <div class="hidden md:flex w-1/2 bg-blue-600 p-12 flex-col justify-between">
                <div>
                    <h1 class="text-white text-3xl font-bold">PRACEDU</h1>
                    <p class="text-blue-200 mt-2">Preparation Center for Education</p>
                </div>
                <div>
                    <h2 class="text-white text-3xl font-bold leading-tight">Jangan Khawatir, Kami Bantu.</h2>
                    <p class="text-blue-100 mt-4">Cukup masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
                </div>
                <div class="text-center text-blue-200 text-sm">
                    &copy; {{ date('Y') }} PRACEDU. All Rights Reserved.
                </div>
            </div>

            <!-- Kolom Kanan - Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Lupa Password Anda?</h2>
                <p class="text-gray-500 mb-8">Masukkan email yang terdaftar.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
                
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input id="email" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-transform transform hover:scale-105">
                            Kirim Tautan Reset Password
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Ingat password Anda? 
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>