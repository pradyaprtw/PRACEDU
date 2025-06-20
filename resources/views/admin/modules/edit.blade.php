@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Modul</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Mata Pelajaran -->
            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                <select name="subject_id" id="subject_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('subject_id') border-red-500 @enderror">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $module->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }} ({{ $subject->subCategory->name }})
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Judul Modul -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Modul:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $module->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload File (PDF, dll) -->
            <div class="mb-4">
                <label for="document" class="block text-gray-700 text-sm font-bold mb-2">Dokumen Modul (biarkan kosong jika tidak ingin mengganti):</label>
                <input type="file" name="document" id="document" accept=".pdf,.doc,.docx,.ppt,.pptx" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('document') border-red-500 @enderror">
                @error('document')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror

                @if ($module->file_path)
                    <p class="text-sm text-gray-500 mt-2">File saat ini: 
                        <a href="{{ Storage::url($module->file_path) }}" target="_blank" class="text-blue-500 underline">Lihat File</a>
                    </p>
                @endif
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.modules.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Modul
                </button>
            </div>
        </form>
    </div>
@endsection
