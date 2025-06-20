<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PRACEDU - Raih Masa Depanmu, Mulai Dari Sini</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-bg {
            background-color: #1a56db; /* Warna biru yang konsisten */
            background-image: linear-gradient(135deg, #1a56db 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="antialiased text-gray-800">
    <div class="bg-white">
        <!-- Header -->
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="text-2xl font-bold text-white">PRACEDU</span>
                    </a>
                </div>
                <div class="flex lg:flex-1 lg:justify-end">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="text-sm font-semibold leading-6 text-white hover:text-gray-200">Dashboard <span aria-hidden="true">&rarr;</span></a>
                        @else
                            <a href="{{ url('/siswa/dashboard') }}" class="text-sm font-semibold leading-6 text-white hover:text-gray-200">Dashboard <span aria-hidden="true">&rarr;</span></a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-white hover:text-gray-200">Log in <span aria-hidden="true">&rarr;</span></a>
                    @endauth
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main>
            <div class="relative isolate overflow-hidden hero-bg">
                <div class="mx-auto max-w-7xl px-6 pb-24 pt-32 sm:pt-48 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Raih PTN Impianmu Bersama PRACEDU</h1>
                        <p class="mt-6 text-lg leading-8 text-blue-100">Platform belajar online terlengkap dengan ribuan video materi, latihan soal, dan Tryout UTBK yang dirancang untuk membantumu sukses.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('register') }}" class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-blue-600 shadow-sm hover:bg-gray-100  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-transform transform hover:scale-105">Daftar Sekarang</a>
                            <a href="#fitur" class="text-sm font-semibold leading-6 text-white">Pelajari lebih lanjut <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fitur Section -->
            <div id="fitur" class="bg-gray-50 py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-blue-600">FITUR UNGGULAN</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Semua yang Kamu Butuhkan untuk Lolos Ujian</p>
                        <p class="mt-6 text-lg leading-8 text-gray-600">Kami menyediakan alat belajar terbaik yang akan menemanimu di setiap langkah persiapan.</p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                        </svg>
                                    </div>
                                    Video Materi Berkualitas
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Pahami konsep sulit dengan mudah melalui video penjelasan yang dibawakan oleh pengajar berpengalaman.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                         <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                    Latihan Soal Interaktif
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Uji pemahamanmu setelah belajar dengan ribuan soal latihan per topik yang dilengkapi pembahasan mendalam.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    Simulasi Ujian Realistis
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Biasakan diri dengan tekanan ujian melalui simulasi UTBK & Mandiri yang mirip dengan aslinya, lengkap dengan timer dan penilaian.</dd>
                            </div>
                             <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3.375m-3.375 2.25h10.5m-10.5 2.25h19.5m-19.5 0l-2.25-2.25m19.5 0l-2.25 2.25m-15-10.5l2.25-2.25m10.5 0l2.25 2.25m-7.5 6l2.25-2.25m3 2.25l2.25 2.25m0 0l2.25 2.25m-2.25-2.25l-2.25-2.25m0 0l-2.25-2.25m2.25 2.25l-2.25 2.25" />
                                        </svg>
                                    </div>
                                    Pembayaran Mudah & Aman
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Pilih paket belajarmu dan bayar dengan mudah melalui berbagai metode pembayaran yang aman dan terpercaya.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

             <!-- CTA Section -->
            <div class="bg-white">
                <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
                    <div class="relative isolate overflow-hidden bg-blue-600 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">
                        <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
                            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Tunggu Apa Lagi?<br>Mulai Persiapanmu Sekarang.</h2>
                            <p class="mt-6 text-lg leading-8 text-blue-100">Jadilah bagian dari ribuan siswa yang telah terbantu meraih kampus impiannya bersama PRACEDU.</p>
                            <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                                <a href="{{ route('register') }}" class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-blue-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Daftar Akun Gratis</a>
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-white">Login <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-900" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
                <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
                    <p class="text-sm leading-5 text-gray-400">&copy; {{ date('Y') }} PRACEDU. Seluruh Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
