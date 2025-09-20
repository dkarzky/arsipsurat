@extends('layouts.app')

@section('content')
<h3>Detail Arsip Surat</h3>
<div class="card mb-3">
  <div class="card-body">
    <dl class="row mb-0">
      <dt class="col-sm-3">Nomor</dt><dd class="col-sm-9">{{ $surat->number ?? '-' }}</dd>
      <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $surat->category->name ?? '-' }}</dd>
      <dt class="col-sm-3">Judul</dt><dd class="col-sm-9">{{ $surat->title }}</dd>
      <dt class="col-sm-3">Ringkasan</dt><dd class="col-sm-9">{{ $surat->description ?? '-' }}</dd>
      <dt class="col-sm-3">Diunggah</dt><dd class="col-sm-9">{{ $surat->created_at->format('d/m/Y H:i') }}</dd>
    </dl>
  </div>
</div>

<div class="mb-3">
  <a class="btn btn-secondary" href="{{ route('surats.index') }}">Kembali <<</a>
  <a class="btn btn-success" href="{{ route('surats.download', $surat) }}">Unduh</a>
</div>

<div class="ratio ratio-16x9 border">
  <iframe src="{{ asset('storage/'.$surat->file_path) }}" title="PDF" width="100%" height="100%"></iframe>
</div>
@endsection
