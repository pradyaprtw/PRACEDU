@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Ujian</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Mata Pelajaran -->
            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                <select name="subject_id" id="subject_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('subject_id') border-red-500 @enderror">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
                           {{ $subject->name }} ({{ $subject->subCategory->name }})
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Judul Ujian -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Ujian:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $exam->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Durasi -->
            <div class="mb-4">
                <label for="duration" class="block text-gray-700 text-sm font-bold mb-2">Durasi (dalam menit):</label>
                <input type="number" name="duration" id="duration" value="{{ old('duration', $exam->duration) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('duration') border-red-500 @enderror">
                @error('duration')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.exams.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Ujian
                </button>
            </div>
        </form>
    </div>
@endsection