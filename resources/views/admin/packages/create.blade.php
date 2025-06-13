@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Paket Langganan Baru</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.packages.store') }}" method="POST">
            @csrf

            <!-- Nama Paket -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Paket:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" placeholder="Contoh: Paket 3 Bulan, Paket Tahunan">
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Harga Paket -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rupiah):</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror" placeholder="Contoh: 100000 (tanpa titik atau koma)">
                @error('price')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Durasi Paket -->
            <div class="mb-4">
                <label for="duration_in_months" class="block text-gray-700 text-sm font-bold mb-2">Durasi (dalam bulan):</label>
                <input type="number" name="duration_in_months" id="duration_in_months" value="{{ old('duration_in_months') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('duration_in_months') border-red-500 @enderror" placeholder="Contoh: 3, 6, 12">
                @error('duration_in_months')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.packages.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>
@endsection