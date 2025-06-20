@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Soal Tryout untuk Subtest: {{ $subtest->name }}</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.tryout.question.store', $subtest->id) }}" method="POST">
        @csrf

        {{-- Teks Soal --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Teks Soal:</label>
            <textarea name="question_text" rows="4" class="w-full border rounded px-3 py-2 @error('question_text') border-red-500 @enderror">{{ old('question_text') }}</textarea>
            @error('question_text')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Pilihan Jawaban --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Pilihan Jawaban:</label>

            @php
                $labels = ['A', 'B', 'C', 'D'];
            @endphp

            @foreach($labels as $index => $label)
                <div class="flex items-center mb-2">
                    <input type="radio" name="correct_answer" value="{{ $label }}" class="mr-2"
                        {{ old('correct_answer') == $label ? 'checked' : '' }}>
                    <span class="mr-2 font-bold">{{ $label }}.</span>
                    <input type="hidden" name="option_labels[]" value="{{ $label }}">
                    <input type="text" name="option_texts[]" class="w-full border rounded px-3 py-2 @error("option_texts.$index") border-red-500 @enderror"
                        placeholder="Isi jawaban pilihan {{ $label }}" value="{{ old('option_texts.'.$index) }}">
                </div>
                @error("option_texts.$index")
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            @endforeach

            @error('correct_answer')
                <p class="text-red-500 text-sm mt-1">Pilih jawaban yang benar.</p>
            @enderror
        </div>

        {{-- Penjelasan --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Penjelasan (Opsional):</label>
            <textarea name="explanation" rows="3" class="w-full border rounded px-3 py-2">{{ old('explanation') }}</textarea>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <a href="{{ route('admin.tryout.show', $subtest->package_id) }}" class="text-gray-600 mr-4">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan Soal
            </button>
        </div>

    </form>
</div>
@endsection
