@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Subtest Baru</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.tryout.subtest.store', $tryoutPackage) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Subtest:</label>
            <input type="text" name="name" id="name" class="border rounded w-full py-2 px-3" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="total_questions" class="block text-gray-700 font-bold mb-2">Jumlah Soal:</label>
            <input type="number" name="total_questions" id="total_questions" class="border rounded w-full py-2 px-3" value="{{ old('total_questions') }}" required>
            @error('total_questions')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="duration_minutes" class="block text-gray-700 font-bold mb-2">Durasi (menit):</label>
            <input type="number" name="duration_minutes" id="duration_minutes" class="border rounded w-full py-2 px-3" value="{{ old('duration_minutes') }}" required>
            @error('duration_minutes')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
