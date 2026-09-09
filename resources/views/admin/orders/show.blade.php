@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card card-primary card-outline">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{ $order->order_number }}</h3>
                @php
                    $badge = match($order->status) {
                        'pending' => 'badge-warning',
                        'diproses' => 'badge-info',
                        'selesai' => 'badge-success',
                        'dibatalkan' => 'badge-danger',
                        default => 'badge-secondary',
                    };
                @endphp
                <span class="badge {{ $badge }} p-2">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
                <dl class="row">
                    <dt class="col-sm-4">Pelanggan</dt>
                    <dd class="col-sm-8">{{ $order->customer_name }}</dd>
                    <dt class="col-sm-4">Nomor Meja</dt>
                    <dd class="col-sm-8">{{ $order->table_number ?: '-' }}</dd>
                    <dt class="col-sm-4">Pembayaran</dt>
                    <dd class="col-sm-8">{{ ucfirst($order->payment_method) }}</dd>
                    @if($order->notes)
                        <dt class="col-sm-4">Catatan</dt>
                        <dd class="col-sm-8">{{ $order->notes }}</dd>
                    @endif
                </dl>

                <table class="table table-sm">
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->menu_name }} <span class="text-muted">x{{ $item->quantity }}</span></td>
                                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td>Total</td>
                            <td class="text-right text-orange" style="color:#d35400;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Ubah Status</h3></div>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <select name="status" class="form-control">
                        @foreach(['pending', 'diproses', 'selesai', 'dibatalkan'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-footer">
                    <button class="btn btn-orange btn-block"><i class="fas fa-sync mr-1"></i> Perbarui Status</button>
                </div>
            </form>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-default btn-block"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
    </div>
</div>
@endsection
