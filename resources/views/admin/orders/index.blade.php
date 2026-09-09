@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Daftar Pesanan</h3>
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(['pending', 'diproses', 'selesai', 'dibatalkan'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
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
                        <td class="text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $orders->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
