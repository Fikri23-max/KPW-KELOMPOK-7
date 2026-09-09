@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $stats['total_menu'] }}</h3>
                <p>Total Menu</p>
            </div>
            <div class="icon"><i class="fas fa-hamburger"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_kategori'] }}</h3>
                <p>Kategori</p>
            </div>
            <div class="icon"><i class="fas fa-tags"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pesanan_pending'] }}</h3>
                <p>Pesanan Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</h3>
                <p>Pendapatan (Selesai)</p>
            </div>
            <div class="icon"><i class="fas fa-wallet"></i></div>
        </div>
    </div>
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Pesanan Terbaru</h3>
        <div class="card-tools">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-orange">Lihat Semua</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananTerbaru as $order)
                    <tr onclick="window.location='{{ route('admin.orders.show', $order) }}'" style="cursor:pointer">
                        <td>{{ $order->order_number }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $badge = match($order->status) {
                                    'pending' => 'badge-warning',
                                    'diproses' => 'badge-info',
                                    'selesai' => 'badge-success',
                                    'dibatalkan' => 'badge-danger',
                                    default => 'badge-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>{{ $order->created_at->translatedFormat('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
