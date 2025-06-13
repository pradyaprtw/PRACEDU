@extends('layouts.student')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $video->title }}</h1>
    <p class="text-gray-600 mb-6">Mata Pelajaran: <a href="{{ route('siswa.content.subject', $video->subject->slug) }}" class="text-blue-600 hover:underline">{{ $video->subject->name }}</a></p>

    @if($youtubeId)
        <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg shadow-lg overflow-hidden">
            <iframe 
                src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        </div>
    @else
        <div class="bg-red-100 p-4 rounded-lg text-red-700">
            Link YouTube tidak valid atau tidak dapat diproses.
        </div>
    @endif
@endsection