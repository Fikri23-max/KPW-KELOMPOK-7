@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h2>
            <p class="text-sm text-gray-400">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
        </div>
        <span @class([
            'text-xs px-3 py-1 rounded-full font-semibold',
            'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
            'bg-blue-100 text-blue-700' => $order->status === 'diproses',
            'bg-green-100 text-green-700' => $order->status === 'selesai',
            'bg-red-100 text-red-700' => $order->status === 'dibatalkan',
        ])>
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="text-sm text-gray-600 mb-4 space-y-1 bg-orange-50/50 rounded-xl p-4">
        <p><strong>Meja:</strong> {{ $order->table_number ?: '-' }}</p>
        <p><strong>Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
        @if($order->notes)
            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
        @endif
    </div>

    <div class="border-t border-dashed pt-3">
        @foreach($order->items as $item)
            <div class="flex justify-between text-sm py-1.5">
                <span>{{ $item->menu_name }} <span class="text-gray-400">x{{ $item->quantity }}</span></span>
                <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    <div class="border-t border-dashed mt-3 pt-3 flex justify-between font-bold text-gray-800">
        <span>Total</span>
        <span class="text-brand-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>

    <a href="{{ route('orders.index') }}" class="inline-block mt-6 text-brand-600 font-semibold text-sm">← Kembali ke Pesanan Saya</a>
</div>
@endsection
