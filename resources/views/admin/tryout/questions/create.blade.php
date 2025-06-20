@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Soal Tryout untuk Subtest: {{ $subtest->name }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.tryout.question.store', $subtest->id) }}" method="POST">
            @csrf

            {{-- Teks Soal --}}
            <div class="mb-4">
                <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Soal:</label>
                <textarea name="question_text" id="question_text" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('question_text') }}</textarea>
            </div>

            {{-- Pilihan Jawaban --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilihan Jawaban:</label>

                @foreach (['A', 'B', 'C', 'D'] as $option)
                <div class="flex items-center mb-2">
                    <input type="radio" name="correct_answer" value="{{ $option }}" class="h-5 w-5 text-blue-600 mr-3" {{ old('correct_answer') == $option ? 'checked' : '' }}>
                    <input type="hidden" name="option_labels[]" value="{{ $option }}">
                    <input type="text" name="option_texts[]" placeholder="Jawaban {{ $option }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('option_texts.'.$loop->index) }}">
                </div>
                @endforeach
            </div>

            {{-- Penjelasan (opsional) --}}
            <div class="mb-4">
                <label for="explanation" class="block text-gray-700 text-sm font-bold mb-2">Penjelasan (Opsional):</label>
                <textarea name="explanation" id="explanation" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('explanation') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
@endsection
