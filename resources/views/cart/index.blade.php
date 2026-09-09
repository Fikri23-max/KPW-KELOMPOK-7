@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center gap-2">
    <i class="fas fa-shopping-basket text-brand-600"></i> Keranjang Belanja
</h2>

@if(empty($cart))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
        <i class="fas fa-basket-shopping text-5xl mb-4"></i>
        <p class="mb-4">Keranjang Anda masih kosong.</p>
        <a href="{{ route('menu.index') }}" class="inline-block bg-brand-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-brand-700 transition">
            ← Lihat Menu
        </a>
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @foreach($cart as $item)
            <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-xl bg-orange-50 overflow-hidden flex-shrink-0 flex items-center justify-center">
                        @if(!empty($item['image']))
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl">🍲</span>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-400">Rp {{ number_format($item['price'], 0, ',', '.') }} / porsi</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('cart.update', $item['menu_id']) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                               class="w-16 border border-gray-200 rounded-full px-3 py-1.5 text-sm text-center" onchange="this.form.submit()">
                    </form>

                    <span class="font-bold text-gray-700 w-28 text-right">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </span>

                    <form action="{{ route('cart.destroy', $item['menu_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 transition"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mt-4 flex justify-between items-center">
        <span class="text-lg font-bold text-gray-800">Total</span>
        <span class="text-2xl font-extrabold text-brand-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
    </div>

    @auth
        <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mt-4 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Meja (opsional)</label>
                <input type="text" name="table_number" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm" placeholder="Contoh: A3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Metode Pembayaran</label>
                <select name="payment_method" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                    <option value="tunai">💵 Tunai</option>
                    <option value="transfer">🏦 Transfer Bank</option>
                    <option value="qris">📱 QRIS</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Catatan (opsional)</label>
                <textarea name="notes" rows="2" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm" placeholder="Contoh: tidak pedas"></textarea>
            </div>
            <button class="w-full bg-brand-600 text-white py-3 rounded-full hover:bg-brand-700 transition font-bold shadow-sm shadow-orange-200">
                <i class="fas fa-check-circle mr-1"></i> Buat Pesanan
            </button>
        </form>
    @else
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl p-4 mt-4 text-center text-sm">
            Silakan <a href="{{ route('login') }}" class="font-semibold underline">masuk</a> terlebih dahulu untuk melanjutkan pemesanan.
        </div>
    @endauth
@endif
@endsection
