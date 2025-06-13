@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Soal</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form 
            action="{{ route('admin.questions.update', $question) }}" 
            method="POST" 
            x-data="{ 
                options: {{ json_encode(old('options', $question->options)) }}, 
                correct_answer: {{ old('correct_answer', $question->correct_answer) }} 
            }"
        >
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Pertanyaan:</label>
                <textarea name="question_text" id="question_text" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question_text') border-red-500 @enderror">{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilihan Jawaban:</label>
                <template x-for="(option, index) in options" :key="index">
                    <div class="flex items-center mb-2">
                        <input type="radio" name="correct_answer" :value="index" x-model="correct_answer" class="mr-2">
                        <input type="text" :name="'options['+index+']'" x-model="options[index]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Teks Pilihan Jawaban">
                        <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2" class="ml-2 text-red-500 hover:text-red-700">&times;</button>
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
                <a href="{{ route('admin.exams.show', $question->exam) }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Soal
                </button>
            </div>
        </form>
    </div>
@endsection