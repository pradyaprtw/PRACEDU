@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">{{ $subtest->name }}</h1>

    <form method="POST" action="{{ route('siswa.tryout.submitSubtest', $subtest->id) }}">
        @csrf
        @foreach ($subtest->tryoutQuestions as $index => $question)
            <div class="mb-6 bg-white p-4 rounded shadow">
                <p class="font-bold mb-3">Soal {{ $index + 1 }}:</p>
                <p class="mb-3">{{ $question->question_text }}</p>

                @foreach ($question->answers as $answer)
                    <label class="block mb-2">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->option_label }}" required>
                        {{ $answer->option_label }}. {{ $answer->answer_text }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Simpan Jawaban Subtest</button>
    </form>
</div>
@endsection
