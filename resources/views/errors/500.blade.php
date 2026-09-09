@extends('layouts.app')

@section('title', 'Terjadi Kesalahan')

@section('content')
<div class="max-w-md mx-auto text-center py-20">
    <div class="text-7xl mb-4">😵</div>
    <h1 class="text-3xl font-extrabold text-gray-800 mb-2">500</h1>
    <p class="text-gray-500 mb-6">Ada yang tidak beres di dapur kami. Coba muat ulang beberapa saat lagi.</p>
    <a href="{{ route('menu.index') }}" class="inline-block bg-brand-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-brand-700 transition">
        ← Kembali ke Menu
    </a>
</div>
@endsection
