@extends('layouts.student')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h1>

    @if($subscription)
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
            <p class="font-bold">Paket Aktif: {{ $subscription->package->name }}</p>
            <p>Langganan Anda aktif sampai dengan tanggal {{ \Carbon\Carbon::parse($subscription->end_date)->format('d F Y') }}.</p>
        </div>
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
            <p class="font-bold">Anda belum memiliki paket aktif.</p>
            <p>Beli paket untuk mendapatkan akses penuh ke semua materi dan simulasi ujian. <a href="{{ route('siswa.packages.index') }}" class="font-bold underline">Lihat Paket</a></p>
        </div>
    @endif
    
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Mulai Belajar</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('siswa.content.category', $category->slug) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-xl font-bold text-gray-800">{{ $category->name }}</h3>
                <p class="text-gray-600 mt-2">
                    Tersedia {{ $category->subCategories->count() }} sub-kategori.
                </p>
            </a>
        @endforeach
    </div>
@endsection