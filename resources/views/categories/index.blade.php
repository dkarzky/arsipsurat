@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('categories.index') }}" class="text-decoration-none">Kategori Surat</a>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h3>Kategori Surat</h3>
        <div class="subtext">Kategori untuk melabeli arsip surat.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
    </div>
</div>

<table class="table table-modern table-borderless align-middle">
    <thead>
        <tr>
            <th width="60">No</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $i => $category)
            <tr>
                <td>{{ $categories->firstItem() + $i }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                                <td>
                                    <div class="btn-toolbar" role="toolbar">
                                        <div class="btn-group me-2" role="group">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form class="d-inline" method="POST" action="{{ route('categories.destroy', $category) }}" data-ajax="true">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmDelete(this)"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Belum ada kategori.</td></tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex justify-content-end">
    {{ $categories->links() }}
</div>
@endsection
