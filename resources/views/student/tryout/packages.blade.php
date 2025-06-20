@extends('layouts.student')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">📘 Daftar Paket Tryout UTBK</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $package)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg border border-gray-200 hover:border-blue-400 transition-all duration-300 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $package->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4 min-h-[60px]">{{ $package->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
                <a href="{{ route('siswa.tryout.subtests', $package->id) }}" 
                   class="mt-4 inline-block bg-blue-600 text-white text-center font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    📑 Lihat Subtest
                </a>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                Belum ada paket tryout tersedia saat ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
