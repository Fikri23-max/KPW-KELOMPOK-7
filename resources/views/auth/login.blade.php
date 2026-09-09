@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-4">
    <div class="text-center mb-6">
        <span class="bg-brand-600 text-white w-14 h-14 rounded-2xl inline-flex items-center justify-center text-2xl mb-3">
            <i class="fas fa-utensils"></i>
        </span>
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-400">Masuk untuk mulai memesan</p>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Kata Sandi</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-400">
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember"> Ingat saya
        </label>
        <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-full hover:bg-brand-700 transition font-bold">
            Masuk
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-5 text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-brand-600 font-semibold">Daftar di sini</a>
    </p>

    <div class="mt-5 text-xs text-gray-400 border-t border-dashed pt-3 text-center">
        Akun contoh admin: admin@resto.test / password
    </div>
</div>
@endsection
