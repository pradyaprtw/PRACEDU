@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Paket Tryout UTBK</h1>

    <div class="grid grid-cols-1 gap-4">
        @foreach($packages as $package)
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-xl font-bold">{{ $package->name }}</h2>
            <p class="text-gray-600">{{ $package->description }}</p>
            <a href="{{ route('siswa.tryout.subtests', $package->id) }}" class="mt-3 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
                Lihat Subtest
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
