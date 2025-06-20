@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Detail Paket: {{ $tryoutPackage->name }}</h1>

<p class="mb-4">{{ $tryoutPackage->description }}</p>

<a href="{{ route('admin.tryout.subtest.create', $tryoutPackage) }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Subtest</a>

<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">Nama Subtest</th>
            <th class="py-2 px-4 border-b">Total Soal</th>
            <th class="py-2 px-4 border-b">Durasi (menit)</th>
            <th class="py-2 px-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tryoutPackage->subtests as $subtest)
        <tr>
            <td class="py-2 px-4 border-b">{{ $subtest->name }}</td>
            <td class="py-2 px-4 border-b">{{ $subtest->total_questions }}</td>
            <td class="py-2 px-4 border-b">{{ $subtest->duration_minutes }}</td>
            <td class="py-2 px-4 border-b">
                <a href="{{ route('admin.tryout.question.create', $subtest) }}" class="text-blue-500">Tambah Soal</a> |
                <form action="{{ route('admin.tryout.subtest.destroy', [$tryoutPackage, $subtest]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus subtest?')" class="text-red-500">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.tryout.index') }}" class="mt-6 inline-block text-blue-500">Kembali ke daftar paket</a>
@endsection
