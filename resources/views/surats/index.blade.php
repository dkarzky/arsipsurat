@extends('layouts.app')

@section('breadcrumb')
  <a href="{{ route('surats.index') }}" class="text-decoration-none">Arsip Surat</a>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h3>Arsip Surat</h3>
        <div class="subtext">Kelola dan cari arsip surat yang telah diunggah.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('surats.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Arsipkan Surat</a>
    </div>
    </div>
<form method="GET" action="{{ route('surats.index') }}" class="row g-2 align-items-center mb-3">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari berdasarkan judul..." value="{{ $q }}" />
                <button class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

<table class="table table-modern table-borderless align-middle">
    <thead>
        <tr>
            <th width="60">No</th>
            <th>Nomor Surat</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Waktu Pengarsipan</th>
            <th width="260">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($surats as $i => $surat)
            <tr>
                <td>{{ $surats->firstItem() + $i }}</td>
                <td>{{ $surat->number ?? '-' }}</td>
                <td>@if($surat->category)<span class="badge-category">{{ $surat->category->name }}</span>@else - @endif</td>
                <td>{{ $surat->title }}</td>
                <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-toolbar" role="toolbar">
                                                        <div class="btn-group me-2" role="group">
                                                            <a class="btn btn-sm btn-soft-primary" href="{{ route('surats.edit', $surat) }}"><i class="bi bi-pencil-square"></i> Edit</a>
                                                            <a class="btn btn-sm btn-primary" href="{{ route('surats.show', $surat) }}"><i class="bi bi-eye"></i> Lihat</a>
                                                            <a class="btn btn-sm btn-soft-primary" href="{{ route('surats.download', $surat) }}"><i class="bi bi-download"></i> Unduh</a>
                                                        </div>
                                                        <div class="btn-group" role="group">
                                                            <form class="d-inline" method="POST" action="{{ route('surats.destroy', $surat) }}" data-ajax="true">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmDelete(this)"><i class="bi bi-trash"></i> Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Belum ada arsip.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-end">
    {{ $surats->links() }}
</div>
@endsection
