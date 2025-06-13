@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Video</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Mata Pelajaran -->
            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                <select name="subject_id" id="subject_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('subject_id') border-red-500 @enderror">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $video->subject_id) == $subject->id ? 'selected' : '' }}>
                           {{ $subject->name }} ({{ $subject->subCategory->name }})
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Judul Video -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Video:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL YouTube -->
            <div class="mb-4">
                <label for="youtube_url" class="block text-gray-700 text-sm font-bold mb-2">URL YouTube:</label>
                <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('youtube_url') border-red-500 @enderror">
                @error('youtube_url')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.videos.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Video
                </button>
            </div>
        </form>
    </div>
@endsection