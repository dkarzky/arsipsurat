@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('surats.index') }}" class="text-decoration-none">Arsip Surat</a>
    <span class="text-muted"> / </span>
    <span class="text-muted">{{ $mode === 'create' ? 'Unggah' : 'Edit' }}</span>
@endsection

@section('content')
<h3>{{ $mode === 'create' ? 'Unggah Arsip Surat' : 'Edit Arsip: ' . ($surat->number ?? $surat->title) }}</h3>
<p class="text-muted">{{ $mode==='create' ? 'Unggah surat yang telah terbit pada form ini untuk diarsipkan.' : 'Edit data arsip surat.' }}</p>
@if($mode==='create')
<div class="mb-3"><strong>Catatan:</strong>
    <ul class="mb-0">
        <li>Gunakan file berformat PDF</li>
    </ul>
</div>
@else
<div class="mb-3"><strong>Catatan:</strong>
    <ul class="mb-0">
        <li>Isi file baru jika ingin mengganti file yang sudah ada</li>
        <li>Kosongkan file jika hanya ingin mengubah data tanpa mengganti file</li>
        <li>Gunakan file berformat PDF</li>
    </ul>
</div>
@endif
<form method="POST" enctype="multipart/form-data" action="{{ $mode==='create' ? route('surats.store') : route('surats.update', $surat) }}" class="mt-3">
    @csrf
    @if($mode==='edit')
        @method('PUT')
    @endif
        @if($mode==='edit')
            <div class="mb-3">
                <label class="form-label">ID Arsip</label>
                <input type="text" class="form-control" value="{{ $surat->id }}" readonly>
                <div class="form-text">ID arsip tidak dapat diubah</div>
            </div>
        @endif
        <div class="mb-3">
        <label class="form-label">Nomor Surat</label>
        <input type="text" name="number" value="{{ old('number', $surat->number) }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $surat->category_id)==$cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" value="{{ old('title', $surat->title) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $surat->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Tanggal Surat</label>
        <input type="date" name="date" value="{{ old('date', optional($surat->date)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">{{ $mode==='create' ? 'File Surat (PDF)' : 'File Baru (Opsional)' }}</label>
        @if($mode==='edit' && $surat->file_path)
        <div class="input-group mb-2">
          <input type="text" class="form-control" value="{{ basename($surat->file_path) }}" readonly>
          <a class="btn btn-outline-primary" href="{{ route('surats.download', $surat) }}"><i class="bi bi-download"></i> Download</a>
        </div>
        <div class="form-text">File yang sedang digunakan</div>
        @endif
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-folder2-open"></i></span>
                    <input type="file" name="file" accept="application/pdf" class="form-control" {{ $mode==='create' ? 'required' : '' }}>
                </div>
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
        <a href="{{ route('surats.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> {{ $mode==='create' ? 'Simpan' : 'Simpan Perubahan' }}</button>
    </div>
</form>
@endsection
