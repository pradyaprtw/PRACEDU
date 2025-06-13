@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card Total Siswa -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-600">Total Siswa</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalStudents }}</p>
        </div>

        <!-- Card Total Mata Pelajaran -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-600">Total Mata Pelajaran</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSubjects }}</p>
        </div>

        <!-- Card Total Paket -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-600">Total Paket</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPackages }}</p>
        </div>
    </div>
@endsection