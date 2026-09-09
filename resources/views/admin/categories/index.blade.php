@extends('layouts.admin')

@section('title', 'Kategori Menu')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-tags mr-2"></i>Daftar Kategori</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-orange btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah Menu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td><span class="badge badge-secondary">{{ $category->menus_count }} menu</span></td>
                        <td class="text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i> Ubah
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
