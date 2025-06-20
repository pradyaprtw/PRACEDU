@extends('layouts.student')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-10">🎯 Hasil Tryout: {{ $package->name }}</h1>

    <div class="bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">📊 Ringkasan</h2>
            <p class="text-lg mb-2">
                <span class="font-semibold">Total Soal:</span> {{ $attempt->total_questions }}
            </p>
            <p class="text-lg mb-2">
                <span class="font-semibold">Jawaban Benar:</span> {{ $attempt->correct_answers }}
            </p>
            <p class="text-lg mb-2">
                <span class="font-semibold">Persentase Skor:</span> 
                <span class="text-2xl font-bold text-blue-600">{{ $attempt->score_percentage }}%</span>
            </p>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-6">
            <div class="bg-green-500 h-6 rounded-full text-white text-sm font-semibold flex items-center justify-center transition-all duration-500"
                style="width: {{ $attempt->score_percentage }}%;">
                {{ $attempt->score_percentage }}%
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('siswa.tryout.packages') }}" class="inline-block bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                🔙 Kembali ke Daftar Tryout
            </a>
        </div>
    </div>
</div>
@endsection
