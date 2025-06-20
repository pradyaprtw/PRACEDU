@extends('layouts.student')

@section('content')
<div class="text-center mb-10">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Pilih Paket Belajar</h1>
    <p class="text-lg text-gray-500">Belajar jadi lebih mudah dengan akses penuh ke semua materi premium.</p>
</div>

<div class="flex flex-wrap justify-center gap-10">
    @foreach($packages as $package)
        <div class="w-full max-w-sm bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 transform transition duration-500 hover:scale-105 hover:shadow-2xl">
            <h3 class="text-3xl font-extrabold text-center text-blue-700 mb-4">{{ $package->name }}</h3>
            <div class="text-center my-6">
                <span class="text-5xl font-extrabold text-green-600">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                <p class="text-sm text-gray-500 mt-2">Sekali bayar, akses sepuasnya!</p>
            </div>
            <ul class="text-gray-700 space-y-3 mb-8">
                <li class="flex items-center"><span class="text-green-500 mr-2">✔</span> Semua Video Materi</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✔</span> Semua Modul</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✔</span> Ribuan Latihan Soal</li>
                <li class="flex items-center"><span class="text-green-500 mr-2">✔</span> TryOut UTBK Tak Terbatas</li>
            </ul>
            <form action="{{ route('siswa.packages.checkout') }}" method="POST" class="mt-auto">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold py-3 rounded-xl hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-lg">
                    Beli Sekarang
                </button>
            </form>
        </div>
    @endforeach
</div>
@endsection
