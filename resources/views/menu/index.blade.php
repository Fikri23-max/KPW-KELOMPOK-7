@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')
<div class="hero-gradient rounded-3xl p-8 sm:p-10 mb-8 text-white shadow-lg shadow-orange-200 relative overflow-hidden">
    <div class="relative z-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">Lapar? Pesan Sekarang Juga! 🍽️</h1>
        <p class="text-orange-50 max-w-md">Menu segar setiap hari, langsung dari dapur ke meja Anda. Pilih favorit Anda di bawah ini.</p>
    </div>
    <div class="absolute -right-6 -bottom-8 text-9xl opacity-20 select-none">🍜</div>
</div>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <h2 class="text-xl font-bold text-gray-800">Menu Makanan &amp; Minuman</h2>

    <form action="{{ route('menu.index') }}" method="GET" class="flex flex-wrap gap-2">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari menu..."
                   class="border border-gray-200 rounded-full pl-9 pr-4 py-2 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-brand-400">
        </div>
        <select name="category" class="border border-gray-200 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button class="bg-brand-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-brand-700 transition">Cari</button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($menus as $menu)
        <div class="card-hover bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="h-44 bg-gradient-to-br from-orange-100 to-amber-50 flex items-center justify-center text-gray-400 relative">
                @if($menu->is_featured)
                    <span class="absolute top-3 left-3 bg-amber-400 text-amber-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        <i class="fas fa-star mr-1"></i>Pilihan
                    </span>
                @endif
                @if($menu->image_url)
                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-6xl">🍲</span>
                @endif
            </div>
            <div class="p-5 flex flex-col flex-1">
                <span class="text-[11px] text-brand-600 font-bold uppercase tracking-wide">{{ $menu->category->name }}</span>
                <h3 class="font-bold text-gray-800 mt-1 text-lg">{{ $menu->name }}</h3>
                <p class="text-sm text-gray-500 mt-1 flex-1 leading-relaxed">{{ Str::limit($menu->description, 80) }}</p>
                <div class="flex items-center justify-between mt-4">
                    <span class="font-extrabold text-brand-600 text-lg">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('cart.store', $menu) }}" method="POST" class="mt-4 flex gap-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" class="w-16 border border-gray-200 rounded-full px-3 py-2 text-sm text-center">
                    <button class="flex-1 bg-brand-600 text-white rounded-full px-3 py-2 text-sm font-semibold hover:bg-brand-700 transition shadow-sm shadow-orange-200">
                        <i class="fas fa-cart-plus mr-1"></i> Tambah
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-400">
            <i class="fas fa-utensils text-4xl mb-3"></i>
            <p>Belum ada menu yang tersedia.</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $menus->links() }}
</div>
@endsection
