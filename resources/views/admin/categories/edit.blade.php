@extends('layouts.admin')

@section('title', 'Ubah Kategori')

@section('content')
<div class="card card-primary card-outline col-lg-6 p-0">
    <div class="card-header"><h3 class="card-title">Ubah Kategori</h3></div>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-control">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-orange"><i class="fas fa-save mr-1"></i> Perbarui</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
