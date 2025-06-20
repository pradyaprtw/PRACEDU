@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Buat Paket Tryout Baru</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.tryout.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Paket:</label>
            <input type="text" name="name" id="name" class="border rounded w-full py-2 px-3" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi (opsional):</label>
            <textarea name="description" id="description" class="border rounded w-full py-2 px-3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
