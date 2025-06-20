@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Jawaban untuk Soal</h1>

<div class="bg-white shadow-md rounded p-4">
    <form action="{{ route('admin.tryout.answer.store', $tryoutQuestion) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Label Pilihan (A, B, C, D, dst):</label>
            <input type="text" name="option_label" class="w-full border rounded p-2" maxlength="1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Teks Jawaban:</label>
            <textarea name="answer_text" rows="3" class="w-full border rounded p-2" required></textarea>
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_correct" value="1" class="form-checkbox">
                <span class="ml-2">Jawaban Benar?</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Jawaban</button>
    </form>
</div>
@endsection
