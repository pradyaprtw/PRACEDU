@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">{{ $package->name }}</h1>

    <ul class="mb-6">
        @foreach ($subtests as $subtest)
            <li class="mb-4">
                <a href="{{ route('siswa.tryout.questions', $subtest->id) }}" class="text-blue-600 hover:underline">
                    {{ $subtest->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('siswa.tryout.submitPackage', $package->id) }}">
        @csrf
        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded">
            Kumpulkan Seluruh Tryout
        </button>
    </form>
</div>
@endsection
