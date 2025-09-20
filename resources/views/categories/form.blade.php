@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('categories.index') }}" class="text-decoration-none">Kategori Surat</a>
    <span class="text-muted"> / </span>
    <span class="text-muted">{{ $mode==='create' ? 'Tambah' : 'Edit - ' . $category->name }}</span>
@endsection

@section('content')
<h3>{{ $mode === 'create' ? 'Tambah Kategori Baru' : 'Edit Kategori: ' . $category->name }}</h3>
<form method="POST" action="{{ $mode==='create' ? route('categories.store') : route('categories.update', $category) }}" class="mt-3">
    @csrf
    @if($mode==='edit')
        @method('PUT')
    @endif

        @if($mode==='edit')
            <div class="mb-3">
                <label class="form-label">ID Kategori</label>
                <input type="text" class="form-control" value="{{ $category->id }}" readonly>
                <div class="form-text">ID kategori tidak dapat diubah</div>
            </div>
        @endif
        <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex gap-2">
        <a href="{{ route('categories.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Simpan</button>
    </div>
</form>
@endsection
