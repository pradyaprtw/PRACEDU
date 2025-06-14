@extends('layouts.student')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $subject->name }}</h1>

    <!-- Video Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Video Pembelajaran</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($subject->videos as $video)
            <a href="{{ route('siswa.content.video', $video->id) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-4">
                <p class="font-semibold text-gray-800">▶️ {{ $video->title }}</p>
            </a>
            @empty
            <p class="text-gray-500">Belum ada video untuk mata pelajaran ini.</p>
            @endforelse
        </div>
    </div>
    
    <!-- Modul Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Modul Teks</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($subject->modules as $module)
            <a href="{{ Storage::url($module->file_path) }}" target="_blank" class="block bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-4">
                <p class="font-semibold text-gray-800">📄 {{ $module->title }}</p>
            </a>
            @empty
            <p class="text-gray-500">Belum ada modul untuk mata pelajaran ini.</p>
            @endforelse
        </div>
    </div>

    <!-- Ujian Section -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Simulasi Ujian</h2>
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($subject->exams as $exam)
            <a href="{{ route('siswa.exam.show', $exam->id) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-4">
                <p class="font-semibold text-gray-800">📝 {{ $exam->title }}</p>
                 <p class="text-sm text-gray-500">{{ $exam->questions_count }} Soal, {{ $exam->duration }} Menit</p>
            </a>
            @empty
            <p class="text-gray-500">Belum ada ujian untuk mata pelajaran ini.</p>
            @endforelse
        </div>
    </div>
@endsection