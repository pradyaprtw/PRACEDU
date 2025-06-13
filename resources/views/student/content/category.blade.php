@extends('layouts.student')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $category->name }}</h1>

    @forelse($category->subCategories as $subCategory)
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">{{ $subCategory->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($subCategory->subjects as $subject)
                    <a href="{{ route('siswa.content.subject', $subject->slug) }}" class="block p-4 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                        <h3 class="font-semibold text-gray-800">{{ $subject->name }}</h3>
                    </a>
                @empty
                    <p class="text-gray-500 col-span-full">Belum ada mata pelajaran untuk sub-kategori ini.</p>
                @endforelse
            </div>
        </div>
    @empty
         <p class="text-gray-500">Belum ada sub-kategori untuk kategori ini.</p>
    @endforelse
@endsection