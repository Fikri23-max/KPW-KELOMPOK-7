@extends('layouts.admin')

@section('title', 'Menu Makanan')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-hamburger mr-2"></i>Daftar Menu</h3>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-orange btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Menu
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.menus.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width: 320px;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari menu..." class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>
                            @if($menu->image_url)
                                <img src="{{ $menu->image_url }}" class="img-circle" style="width:40px;height:40px;object-fit:cover;">
                            @else
                                <span class="text-muted"><i class="fas fa-image fa-lg"></i></span>
                            @endif
                        </td>
                        <td>
                            {{ $menu->name }}
                            @if($menu->is_featured)
                                <span class="badge badge-warning ml-1"><i class="fas fa-star"></i></span>
                            @endif
                        </td>
                        <td>{{ $menu->category->name }}</td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>
                            @if($menu->is_available)
                                <span class="badge badge-success">Tersedia</span>
                            @else
                                <span class="badge badge-secondary">Habis</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i> Ubah
                            </a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada menu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $menus->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
