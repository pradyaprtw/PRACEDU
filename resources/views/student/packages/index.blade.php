@extends('layouts.student')

@section('content')
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pilih Paket Belajar</h1>
        <p class="text-gray-600 mb-8">Dapatkan akses tak terbatas ke ribuan video, modul, dan soal latihan.</p>
    </div>

    <div class="flex flex-wrap justify-center gap-8">
        @foreach($packages as $package)
            <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-8 flex flex-col">
                <h3 class="text-2xl font-bold text-center text-gray-800">{{ $package->name }}</h3>
                <div class="text-center my-6">
                    <span class="text-4xl font-extrabold">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                </div>
                <ul class="text-gray-600 space-y-2 mb-8">
                    <li>✔️ Akses semua video materi</li>
                    <li>✔️ Akses semua modul & rangkuman</li>
                    <li>✔️ Akses semua bank soal</li>
                    <li>✔️ Simulasi ujian tanpa batas</li>
                </ul>
                <form action="{{ route('siswa.packages.checkout') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Beli Paket
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endsection