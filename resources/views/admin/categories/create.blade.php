@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card card-primary card-outline col-lg-6 p-0">
    <div class="card-header"><h3 class="card-title">Tambah Kategori Baru</h3></div>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="form-control" placeholder="Contoh: Minuman Dingin">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-orange"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
