@extends('layouts.student')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Halo, {{ Auth::user()->name }} 👋</h1>
        <p class="text-lg text-gray-500">Selamat datang di platform belajar kamu. Ayo capai target impianmu!</p>
    </div>

    @if($subscription)
        <div class="flex justify-center mb-8">
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 border-l-4 border-blue-500 text-blue-800 p-6 rounded-xl shadow-md max-w-xl w-full">
                <p class="text-xl font-semibold mb-2">📦 Paket Aktif: <span class="font-bold">{{ $subscription->package->name }}</span></p>
                <p>Langganan aktif sampai <span class="font-bold">{{ \Carbon\Carbon::parse($subscription->end_date)->translatedFormat('d F Y') }}</span>.</p>
            </div>
        </div>
    @else
        <div class="flex justify-center mb-8">
            <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded-xl shadow-md max-w-xl w-full">
                <p class="text-xl font-semibold mb-2">⚠️ Belum Ada Paket Aktif</p>
                <p>Yuk aktifkan paket untuk dapat mengakses semua video, modul, dan simulasi ujian. 
                    <a href="{{ route('siswa.packages.index') }}" class="font-bold underline text-blue-700 hover:text-blue-900">Lihat Paket</a>
                </p>
            </div>
        </div>
    @endif

    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Pilih Kategori Belajar</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($categories as $category)
            <a href="{{ route('siswa.content.category', $category->slug) }}" 
               class="group block bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 border border-gray-200 hover:border-blue-400">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 rounded-full mb-4 group-hover:bg-blue-200">
                    📚
                </div>
                <h3 class="text-xl font-bold text-center text-gray-800 group-hover:text-blue-700">{{ $category->name }}</h3>
                <p class="text-center text-gray-500 mt-2">{{ $category->subCategories->count() }} sub-kategori tersedia</p>
            </a>
        @endforeach
    </div>
@endsection
