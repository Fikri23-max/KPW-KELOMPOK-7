@extends('layouts.admin')

@section('title', 'Tambah Menu')

@section('content')
<div class="card card-primary card-outline col-lg-7 p-0">
    <div class="card-header"><h3 class="card-title">Tambah Menu Baru</h3></div>
    <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('admin.menus._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-orange"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
