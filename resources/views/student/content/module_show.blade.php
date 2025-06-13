@extends('layouts.student')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $module->title }}</h1>
    <p class="text-gray-600 mb-6">Mata Pelajaran: <a href="{{ route('siswa.content.subject', $module->subject->slug) }}" class="text-blue-600 hover:underline">{{ $module->subject->name }}</a></p>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="prose max-w-none">
            {!! nl2br(e($module->content)) !!}
        </div>
    </div>
@endsection
