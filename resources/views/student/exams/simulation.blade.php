@extends('layouts.student')

@section('content')
<div x-data="examTimer({{ $remainingSeconds }})" x-init="startTimer()" class="max-w-4xl mx-auto">
    <form id="exam-form" action="{{ route('siswa.exam.submit', $userExamAttempt) }}" method="POST">
        @csrf
        <div class="bg-white rounded-lg shadow-md p-4 mb-6 sticky top-0 z-10 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">{{ $userExamAttempt->exam->title }}</h1>
            <div class="text-lg font-bold text-red-600 bg-red-100 px-4 py-2 rounded-md">
                Sisa Waktu: <span x-text="displayTime"></span>
            </div>
        </div>

        @foreach($userExamAttempt->exam->questions as $index => $question)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <p class="font-semibold text-gray-800 mb-4">Soal #{{ $index + 1 }}</p>
            <div class="prose max-w-none mb-4">
                {!! nl2br(e($question->question_text)) !!}
            </div>
            
            <div class="space-y-3">
                @foreach($question->options as $key => $option)
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="h-5 w-5 text-blue-600">
                    <span class="ml-3 text-gray-700">{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-300 text-lg">
            Kumpulkan Jawaban
        </button>
    </form>
</div>

<script>
    function examTimer(seconds) {
        return {
            totalSeconds: seconds,
            displayTime: '00:00:00',
            startTimer() {
                if (this.totalSeconds <= 0) return;

                const timer = setInterval(() => {
                    this.totalSeconds--;

                    const hours = Math.floor(this.totalSeconds / 3600);
                    const minutes = Math.floor((this.totalSeconds % 3600) / 60);
                    const secs = this.totalSeconds % 60;

                    this.displayTime = 
                        `${String(hours).padStart(2, '0')}:` +
                        `${String(minutes).padStart(2, '0')}:` +
                        `${String(secs).padStart(2, '0')}`;
                    
                    if (this.totalSeconds <= 0) {
                        clearInterval(timer);
                        document.getElementById('exam-form').submit();
                    }
                }, 1000);
            }
        }
    }
</script>
@endsection