@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Hasil Tryout: {{ $package->name }}</h1>

    <p>Total Soal: {{ $attempt->total_questions }}</p>
    <p>Jawaban Benar: {{ $attempt->correct_answers }}</p>
    <p>Persentase: {{ $attempt->score_percentage }}%</p>
</div>
@endsection
