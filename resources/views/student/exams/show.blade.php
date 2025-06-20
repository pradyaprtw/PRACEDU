@extends('layouts.student')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $exam->title }}</h1>
    <p class="text-gray-600 mb-6">{{ $exam->subject->name }}</p>

    <div class="grid grid-cols-2 gap-4 text-left border-t border-b py-6 my-6">
        <div>
            <p class="text-sm text-gray-500">Jumlah Soal</p>
            <p class="text-xl font-bold">{{ $exam->questions_count }} Soal</p>
        </div>
    </div>

    <div class="prose max-w-none mb-8 text-left">
        <h3 class="font-semibold">Petunjuk Pengerjaan</h3>
        <ol class="list-decimal list-inside">
            <li>Pastikan koneksi internet stabil.</li>
            <li>Jangan refresh halaman selama ujian.</li>
        </ol>
    </div>

    <form action="{{ route('siswa.exam.start', $exam->id) }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors duration-300 text-lg">
            Mulai Ujian
        </button>
    </form>
</div>
@endsection
