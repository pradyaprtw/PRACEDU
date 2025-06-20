@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Tambah Soal - {{ $subtest->name }}</h1>

    <div class="mb-4">
        <p class="text-gray-600">
            <span class="font-semibold text-gray-800">Jumlah Soal Saat Ini:</span> 
            {{ $subtest->tryoutQuestions->count() }} / {{ $subtest->total_questions }}
        </p>
    </div>

    <form method="POST" action="{{ route('admin.tryout.question.store', $subtest->id) }}">
        @csrf

        <div class="mb-6">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Pertanyaan:</label>
            <textarea name="question_text" class="w-full border border-blue-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" rows="4" required></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold text-gray-700 mb-3">Pilihan Jawaban:</label>
            @foreach(['A', 'B', 'C', 'D'] as $label)
                <div class="flex items-center mb-3">
                    <span class="w-8 font-bold text-blue-600">{{ $label }}.</span>
                    <input type="hidden" name="option_labels[]" value="{{ $label }}">
                    <input type="text" name="option_texts[]" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Isi jawaban {{ $label }}" required>
                </div>
            @endforeach
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Jawaban Benar:</label>
            <select name="correct_answer" class="w-full border border-blue-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                <option value="">-- Pilih Jawaban --</option>
                @foreach(['A', 'B', 'C', 'D'] as $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold py-3 rounded-lg hover:from-blue-600 hover:to-blue-800 transition-all duration-300">
            Simpan Soal
        </button>
    </form>
</div>
@endsection
