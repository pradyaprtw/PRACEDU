@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Soal untuk Ujian: {{ $exam->title }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.exams.questions.store', $exam) }}" method="POST" x-data="{ options: ['',''], correct_answer: 0 }">
            @csrf
            
            <div class="mb-4">
                <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Pertanyaan:</label>
                <textarea name="question_text" id="question_text" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question_text') border-red-500 @enderror">{{ old('question_text') }}</textarea>
                @error('question_text')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilihan Jawaban (Pilih jawaban yang benar):</label>
                <template x-for="(option, index) in options" :key="index">
                    <div class="flex items-center mb-2">
                        <input type="radio" name="correct_answer" :value="index" x-model="correct_answer" class="mr-2 h-5 w-5 text-blue-600 focus:ring-blue-500">
                        <input type="text" :name="'options['+index+']'" x-model="options[index]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Teks Pilihan Jawaban">
                        <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2" class="ml-2 text-red-500 hover:text-red-700 font-bold text-xl">&times;</button>
                    </div>
                </template>
                 @error('options.*')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                 @error('correct_answer')
                    <p class="text-red-500 text-xs italic mt-2">Anda harus memilih satu jawaban yang benar.</p>
                @enderror
                <button type="button" @click="options.push('')" class="mt-2 text-sm text-blue-500 hover:text-blue-700">+ Tambah Pilihan</button>
            </div>
            
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.exams.show', $exam) }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
@endsection