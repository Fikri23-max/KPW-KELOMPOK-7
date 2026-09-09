@extends('layouts.admin')

@section('title', 'Ubah Menu')

@section('content')
<div class="card card-primary card-outline col-lg-7 p-0">
    <div class="card-header"><h3 class="card-title">Ubah Menu</h3></div>
    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.menus._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-orange"><i class="fas fa-save mr-1"></i> Perbarui</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
