@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Modul</h1>
        <a href="{{ route('admin.modules.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Tambah Modul Baru
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Judul Modul
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Mata Pelajaran
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($modules as $module)
                <tr>
                    <!-- Judul Modul -->
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $module->title }}
                    </td>

                    <!-- Mata Pelajaran -->
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $module->subject->name }} 
                        @if($module->subject->subCategory)
                            ({{ $module->subject->subCategory->name }})
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                        <a href="{{ Storage::url($module->file_path) }}" target="_blank" class="text-green-600 hover:text-green-900 mr-4">Lihat File</a>
                        <a href="{{ route('admin.modules.edit', $module) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                        <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                        Tidak ada data untuk ditampilkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $modules->links() }}
    </div>
@endsection
