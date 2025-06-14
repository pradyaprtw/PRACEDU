@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Unggah Modul Baru</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- PENTING: Tambahkan enctype untuk form upload file --}}
        <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Dropdown Mata Pelajaran (sama seperti sebelumnya) -->
            <div class="mb-4">
                <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                <select name="subject_id" id="subject_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                           {{ $subject->name }} ({{ $subject->subCategory->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Judul Modul (sama seperti sebelumnya) -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Modul:</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <!-- Input File (BARU) -->
            <div class="mb-4">
                <label for="document" class="block text-gray-700 text-sm font-bold mb-2">Dokumen Modul (PDF, Word, PPT):</label>
                <input type="file" name="document" id="document" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                @error('document')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Unggah Modul
                </button>
            </div>
        </form>
    </div>
@endsection
