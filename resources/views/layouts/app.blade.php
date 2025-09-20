<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Arsip Surat') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
      .sidebar { min-height: 100vh; }
      .sidebar .brand { padding: 24px 16px; text-align: left; }
      .brand-title { font-weight: 700; font-size: 1.25rem; margin: 4px 0 0; }
      .brand-sub { font-size: .9rem; }
      .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<div class="container-fluid mt-3">
  <div class="row">
    <aside class="col-md-3 col-lg-2 mb-3 sidebar">
      <div class="brand text-center">
        <div class="text-primary" style="font-size:2.4rem"><i class="bi bi-archive"></i></div>
        <div class="brand-title mt-1">Arsip Surat</div>
        <hr>
      </div>
      <div class="menu">
        <div class="section-title">Menu</div>
        <ul class="nav nav-pills flex-column gap-1">
          <li class="nav-item"><a href="{{ route('surats.index') }}" class="nav-link {{ request()->routeIs('surats.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text me-2"></i>Arsip Surat</a></li>
          <li class="nav-item"><a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"><i class="bi bi-tags me-2"></i>Kategori Surat</a></li>
          <li class="nav-item"><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"><i class="bi bi-person-circle me-2"></i>About</a></li>
        </ul>
      </div>
    </aside>
    <main class="col-md-9 col-lg-10">
      @hasSection('breadcrumb')
        <div class="breadcrumb-lite mb-2">@yield('breadcrumb')</div>
      @endif

      <div class="toast-container">
        @if(session('success'))
          <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
              <div class="toast-body">{{ session('success') }}</div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
          </div>
        @endif
        @if(session('error'))
          <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
              <div class="toast-body">{{ session('error') }}</div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
          </div>
        @endif
      </div>

      <div class="soft-card">
        {{ $slot ?? '' }}
        @yield('content')
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(button){
    const form = button.closest('form');
    const modalEl = document.getElementById('confirmDeleteModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
    modalEl.querySelector('#confirmYes').onclick = () => {
        modal.hide();
        // ajax submit for smooth UX
        if(form.dataset.ajax === 'true'){
            fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
                body: new URLSearchParams(new FormData(form))
            }).then(r=>r.json()).then(() => {
                const row = form.closest('tr');
                if(row) row.remove();
            }).catch(() => { form.submit(); });
        } else {
            form.submit();
        }
    };
}
</script>

<!-- Global Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmYes">Ya!</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
