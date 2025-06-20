@extends('layouts.student') 

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $video->title }}</h1>
    <p class="text-gray-600 mb-3">
        Mata Pelajaran: 
        <a href="{{ route('siswa.content.subject', $video->subject->slug) }}" class="text-blue-600 hover:underline">
            {{ $video->subject->name }}
        </a>
    </p>

    <br>

    <!-- Tombol Back di atas -->
    <div class="mb-4">
        <a href="{{ route('siswa.content.subject', $video->subject->slug) }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
            &larr; Kembali
        </a>
    </div>

    <br>

    @if($youtubeId)
        <div class="w-full max-w-7xl mx-auto bg-black rounded-lg shadow-lg overflow-hidden mb-8" style="aspect-ratio: 16/9;">
            <iframe 
                src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        </div>
    @else
        <div class="bg-red-100 p-4 rounded-lg text-red-700 mb-8">
            Link YouTube tidak valid atau tidak dapat diproses.
        </div>
    @endif
@endsection
