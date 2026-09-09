@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="max-w-md mx-auto text-center py-20">
    <div class="text-7xl mb-4">🍽️</div>
    <h1 class="text-3xl font-extrabold text-gray-800 mb-2">404</h1>
    <p class="text-gray-500 mb-6">Waduh, halaman yang Anda cari sepertinya sudah habis dipesan orang lain.</p>
    <a href="{{ route('menu.index') }}" class="inline-block bg-brand-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-brand-700 transition">
        ← Kembali ke Menu
    </a>
</div>
@endsection
