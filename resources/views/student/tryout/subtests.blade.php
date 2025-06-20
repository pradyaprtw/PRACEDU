@extends('layouts.student')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">{{ $package->name }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach ($subtests as $subtest)
            <div class="p-5 rounded-lg shadow-md bg-white border border-gray-200 flex flex-col justify-between">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $subtest->name }}</h2>
                    @if(in_array($subtest->id, $attemptedSubtests))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                            ✅ Sudah Dikerjakan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                            🚀 Belum Dikerjakan
                        </span>
                    @endif
                </div>

                @if(!in_array($subtest->id, $attemptedSubtests))
                    <a href="{{ route('siswa.tryout.questions', $subtest->id) }}"
                       class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                        Mulai Subtest
                    </a>
                @else
                    <button class="block text-center bg-gray-300 text-white py-2 rounded cursor-not-allowed" disabled>
                        Selesai
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        <form method="POST" action="{{ route('siswa.tryout.submitPackage', $package->id) }}">
            @csrf
            <button type="submit"
                    class="w-full bg-green-600 text-white py-4 rounded text-lg font-semibold hover:bg-green-700 transition">
                ✅ Kumpulkan Seluruh Tryout
            </button>
        </form>
    </div>
</div>
@endsection
