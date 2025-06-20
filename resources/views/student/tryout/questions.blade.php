@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">{{ $subtest->name }}</h1>

    <!-- TIMER -->
    <div class="mb-6">
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded text-center">
            ⏰ Waktu Tersisa: 
            <span id="timer" class="font-bold text-xl">Loading...</span>
        </div>
    </div>

    <form method="POST" action="{{ route('siswa.tryout.submitSubtest', $subtest->id) }}">
        @csrf
        @foreach ($subtest->tryoutQuestions as $index => $question)
            <div class="mb-6 bg-white p-4 rounded shadow">
                <p class="font-bold mb-3">Soal {{ $index + 1 }}:</p>
                <p class="mb-3">{{ $question->question_text }}</p>
                
                @foreach ($question->answers as $answer)
                    <label class="block mb-2">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->option_label }}">
                        {{ $answer->option_label }}. {{ $answer->answer_text }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Kumpulkan Jawaban Subtest</button>
    </form>
</div>

<script>
    let duration = {{ $durationMinutes * 60 }};
    let timerDisplay = document.getElementById('timer');

    function startTimer() {
        let interval = setInterval(function() {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (--duration < 0) {
                clearInterval(interval);
                alert("Waktu Habis! Jawaban otomatis dikumpulkan.");
                document.querySelector('form').submit();
            }
        }, 1000);
    }

    startTimer();
</script>
@endsection
