@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-700">Detail Ujian: {{ $exam->title }}</h1>
            <p class="text-gray-600">Mapel: {{ $exam->subject->name }}, Durasi: {{ $exam->duration }} menit</p>
        </div>
        <a href="{{ route('admin.exams.questions.create', ['exam' => $exam->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Tambah Soal
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Daftar Soal ({{ $exam->questions->count() }})</h2>
        </div>
        <div>
            @forelse ($exam->questions as $index => $question)
                <div class="p-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div class="flex justify-between">
                        <div class="flex-1">
                           <p class="font-semibold text-gray-800">Soal {{ $index + 1 }}:</p>
                           <p class="mt-1 text-gray-700">{!! nl2br(e($question->question_text)) !!}</p>
                           <ul class="mt-3 list-decimal list-inside space-y-1">
                               @foreach($question->options as $key => $option)
                                   <li class="{{ $key == $question->correct_answer ? 'font-bold text-green-600' : 'text-gray-600' }}">
                                       {{ $option }}
                                       @if($key == $question->correct_answer)
                                           <span class="text-xs text-green-700">(Jawaban Benar)</span>
                                       @endif
                                   </li>
                               @endforeach
                           </ul>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="p-4 text-center text-gray-500">Belum ada soal untuk ujian ini.</p>
            @endforelse
        </div>
    </div>
@endsection