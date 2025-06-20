@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Paket Tryout</h1>

<a href="{{ route('admin.tryout.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Paket Tryout</a>

<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">Nama Paket</th>
            <th class="py-2 px-4 border-b">Jumlah Subtest</th>
            <th class="py-2 px-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
        <tr>
            <td class="py-2 px-4 border-b">{{ $package->name }}</td>
            <td class="py-2 px-4 border-b">{{ $package->subtests->count() }}</td>
            <td class="py-2 px-4 border-b">
                <a href="{{ route('admin.tryout.show', $package) }}" class="text-blue-500">Detail</a> |
                <form action="{{ route('admin.tryout.destroy', $package) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin?')" class="text-red-500">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $packages->links() }}
@endsection
