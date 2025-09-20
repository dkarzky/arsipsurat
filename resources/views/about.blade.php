@extends('layouts.app')

@section('breadcrumb')
  <a href="{{ route('surats.index') }}" class="text-decoration-none">Arsip Surat</a>
  <span class="text-muted"> / </span>
  <span class="text-muted">About</span>
@endsection

@section('content')
<div class="page-header">
  <div>
    <h3>About</h3>
    <div class="subtext">Informasi pembuat aplikasi Arsip Surat.</div>
  </div>
</div>

<div class="row g-4 align-items-start">
  <div class="col-md-4 d-flex justify-content-center">
    <img src="{{ $photo }}" alt="Foto" class="img-fluid" style="max-width:220px;border-radius:12px;border:1px solid var(--border);padding:6px;background:#fff;"/>
  </div>
  <div class="col-md-8">
    <div class="soft-card">
      <h5 class="mb-3">Aplikasi ini dibuat oleh:</h5>
      <table class="table w-auto mb-0">
        <tr><th class="pe-4">Nama</th><td>: {{ $name }}</td></tr>
        <tr><th class="pe-4">NIM</th><td>: {{ $nim }}</td></tr>
        <tr><th class="pe-4">Prodi</th><td>: {{ $prodi }}</td></tr>
        <tr><th class="pe-4">Tanggal</th><td>: {{ $date }}</td></tr>
        <tr>
          <th class="pe-4">Repository</th>
          <td>:
            <a href="https://github.com/dkarzky/arsipsurat" target="_blank" rel="noopener">github.com/dkarzky/arsipsurat</a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection
