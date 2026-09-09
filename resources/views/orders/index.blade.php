@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-5 flex items-center gap-2">
    <i class="fas fa-receipt text-brand-600"></i> Pesanan Saya
</h2>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">
    @forelse($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="flex items-center justify-between p-4 hover:bg-orange-50/50 transition">
            <div>
                <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                <p class="text-sm text-gray-400">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
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
        </a>
    @empty
        <p class="p-10 text-center text-gray-400">Anda belum memiliki pesanan.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
