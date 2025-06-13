@extends('layouts.student')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-10 text-center">
    <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
    <p class="text-gray-600 mb-6">Terima kasih. Paket langganan Anda telah aktif. Selamat belajar!</p>
    <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition-colors duration-300">
        Mulai Belajar
    </a>
</div>
@endsection