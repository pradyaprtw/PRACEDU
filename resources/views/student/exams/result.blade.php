@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Hasil Ujian: {{ $userExamAttempt->exam->title }}</h1>
        <p class="text-gray-600">Selesai pada: {{ \Carbon\Carbon::parse($userExamAttempt->end_time)->format('d F Y, H:i') }}</p>
        
        <div class="my-6">
            <p class="text-lg text-gray-700">Skor Anda:</p>
            <p class="text-6xl font-extrabold text-blue-600">{{ round($userExamAttempt->score) }}</p>
        </div>
        
        <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
    </div>

    <h2 class="text-xl font-semibold text-gray-700 mb-4">Pembahasan Soal</h2>
    
    @php
        $userAnswers = $userExamAttempt->answers->keyBy('question_id');
    @endphp

    @foreach($userExamAttempt->exam->questions as $index => $question)
        @php
            $userAnswer = $userAnswers[$question->id] ?? null;
            $userAnswerIndex = $userAnswer ? $userAnswer->user_answer : null;
            $isCorrect = ($userAnswerIndex !== null && $userAnswerIndex == $question->correct_answer);
        @endphp
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start">
                <p class="font-semibold text-gray-800 mb-4">Soal #{{ $index + 1 }}</p>
                @if($isCorrect)
                    <span class="text-xs font-bold text-green-700 bg-green-100 px-2 py-1 rounded-full">Benar</span>
                @else
                    <span class="text-xs font-bold text-red-700 bg-red-100 px-2 py-1 rounded-full">Salah</span>
                @endif
            </div>
            <div class="prose max-w-none mb-4">
                {!! nl2br(e($question->question_text)) !!}
            </div>
            
            <div class="space-y-3">
                @foreach($question->options as $key => $option)
                    @php
                        $isUserChoice = ($userAnswerIndex !== null && $key == $userAnswerIndex);
                        $isCorrectChoice = ($key == $question->correct_answer);
                        $class = 'border-gray-200';
                        if ($isUserChoice && !$isCorrectChoice) $class = 'border-red-500 bg-red-50'; // Jawaban user, tapi salah
                        if ($isCorrectChoice) $class = 'border-green-500 bg-green-50'; // Jawaban yang benar
                    @endphp
                    <div class="flex items-center p-3 border rounded-lg {{ $class }}">
                        <span class="ml-3 text-gray-700">{{ $option }}</span>
                        @if($isCorrectChoice) <span class="ml-auto text-xs font-bold text-green-700">(Jawaban Benar)</span> @endif
                    </div>
                @endforeach
                 @if($userAnswerIndex === null)
                    <div class="p-3 border rounded-lg border-yellow-500 bg-yellow-50 text-yellow-700">
                        Tidak Dijawab
                    </div>
                 @endif
            </div>
        </div>
    @endforeach
</div>
@endsection