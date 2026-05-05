@extends('backend.layouts.app')

@section('title', 'Manajemen Mata Pelajaran')
@section('page_title', 'Manajemen Mata Pelajaran')

@push('css')
<style>
/* ── Wrapper scroll horizontal ── */
.table-wrap {
    overflow-x: auto;
    border-radius: 0;
}

/* ── Tabel utama ── */
.table-main {
    font-size: .85rem;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

/* ── Sticky header ── */
.table-main thead th {
    position: sticky;
    top: 0;
    background-color: #198754;
    color: #fff;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 10px 12px;
    border: 1px solid #146c43;
    z-index: 2;
}

/* ── Sticky kolom CHECKBOX + NO + KODE ── */
.table-main th.col-check, .table-main td.col-check { position: sticky; left: 0; z-index: 3; min-width: 40px; text-align: center; }
.table-main th.col-no, .table-main td.col-no { position: sticky; left: 40px; z-index: 3; min-width: 50px; text-align: center; }
.table-main th.col-kode, .table-main td.col-kode { position: sticky; left: 90px; z-index: 3; min-width: 100px; text-align: center; }

.table-main thead th.col-check, .table-main thead th.col-no, .table-main thead th.col-kode { z-index: 4; background-color: #198754; }

.table-main tbody td.col-check, .table-main tbody td.col-no, .table-main tbody td.col-kode { background-color: #fff; }
.table-main tbody td.col-kode { border-right: 2px solid #dee2e6; }

.table-main tbody tr:nth-child(even) td.col-check,
.table-main tbody tr:nth-child(even) td.col-no,
.table-main tbody tr:nth-child(even) td.col-kode { background-color: #f8f9fa; }

/* ── Baris data ── */
.table-main tbody tr { transition: background .15s; }
.table-main tbody tr:hover td { background-color: #e8f4fd !important; }
.table-main tbody td {
    padding: 8px 12px;
    vertical-align: middle;
    border: 1px solid #dee2e6;
    white-space: nowrap;
}

/* ── Pagination ── */
.pagination { margin: 0; }
.pagination .page-link { font-size: .8rem; padding: 4px 9px; }
</style>
@endpush

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2">
        <i class="bi bi-x-circle-fill me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">

    {{-- ── Header card ── --}}
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex flex-wrap align-items-center gap-2">

            <h5 class="mb-0 fw-bold text-success me-auto">
                <i class="bi bi-journal-bookmark-fill me-1"></i> Daftar Mapel
            </h5>

            {{-- Per-page --}}
            <form method="GET" action="{{ route('admin.subjects.index') }}" class="d-flex align-items-center gap-2">
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('direction')) <input type="hidden" name="direction" value="{{ request('direction') }}"> @endif
                <span class="text-muted small">Tampilkan</span>
                <select name="per_page" class="form-select form-select-sm" style="width:70px" onchange="this.form.submit()">
                    @foreach([10, 20, 30, 50, 100] as $opt)
                        <option value="{{ $opt }}" {{ ($subjects->perPage() == $opt) ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </form>

            <div class="vr mx-1"></div>

            {{-- Sorting --}}
            <form method="GET" action="{{ route('admin.subjects.index') }}" class="d-flex align-items-center gap-2">
                @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                <span class="text-muted small"><i class="bi bi-sort-alpha-down"></i></span>
                <select name="sort_direction" class="form-select form-select-sm" style="width:130px" onchange="window.location.href=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'urutan', 'direction' => 'asc']) }}" 
                        {{ request('sort', 'urutan') == 'urutan' && request('direction', 'asc') == 'asc' ? 'selected' : '' }}>Urutan (1-9)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => 'asc']) }}" 
                        {{ request('sort') == 'nama' && request('direction') == 'asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => 'desc']) }}"
                        {{ request('sort') == 'nama' && request('direction') == 'desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                </select>
            </form>

            <div class="vr mx-1"></div>

            {{-- Bulk Actions --}}
            <button type="button" id="btnBulkDelete" class="btn btn-sm btn-outline-danger d-none" onclick="bulkDelete()">
                <i class="bi bi-trash"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>

            <div class="vr mx-1 d-none" id="bulkSeparator"></div>

            <a href="{{ route('admin.subjects.template') }}" class="btn btn-sm btn-outline-success">
                <i class="bi bi-download"></i> Template
            </a>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-file-earmark-excel"></i> Import
            </button>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>
        </div>
    </div>

    {{-- ── Tabel ── --}}
    <form id="bulkDeleteForm" action="{{ route('admin.subjects.bulk-delete') }}" method="POST">
        @csrf
        <div class="table-wrap">
            <table class="table-main">
                <thead>
                    <tr>
                        <th class="col-check">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th class="col-no">NO</th>
                        <th class="col-kode">KODE</th>
                        <th>NAMA LENGKAP MATA PELAJARAN</th>
                        <th width="100">URUTAN</th>
                        <th width="100">STATUS</th>
                        <th width="120">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $s)
                    <tr>
                        <td class="col-check">
                            <input type="checkbox" name="ids[]" value="{{ $s->id }}" class="form-check-input item-checkbox">
                        </td>
                        <td class="col-no">{{ $subjects->firstItem() + $index }}</td>
                        <td class="col-kode"><span class="badge text-bg-primary fs-6">{{ $s->kode }}</span></td>
                        <td class="fw-semibold text-dark">{{ $s->nama }}</td>
                        <td class="text-center">{{ $s->urutan }}</td>
                        <td class="text-center">
                            @if($s->aktif)
                                <span class="badge text-bg-success">Aktif</span>
                            @else
                                <span class="badge text-bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $s->id }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="deleteSingle('{{ $s->id }}', '{{ $s->nama }}')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $s->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form action="{{ route('admin.subjects.update', $s->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Mapel: {{ $s->kode }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kode / Singkatan</label>
                                            <input type="text" name="kode" class="form-control text-uppercase" value="{{ $s->kode }}" required maxlength="20">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $s->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Urutan Tampil</label>
                                            <input type="number" name="urutan" class="form-control" value="{{ $s->urutan }}" min="0">
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif{{ $s->id }}" {{ $s->aktif ? 'checked' : '' }}>
                                            <label class="form-check-label" for="aktif{{ $s->id }}">Tampilkan di tabel nilai</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning fw-bold">Update Mapel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-journal-x fs-2 d-block mb-2"></i>
                            Belum ada mata pelajaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    {{-- ── Footer pagination ── --}}
    <div class="card-footer bg-white border-top py-2 px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="text-muted small">
                Menampilkan <strong>{{ $subjects->firstItem() ?? 0 }}</strong>–<strong>{{ $subjects->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $subjects->total() }}</strong> mapel
            </div>
            <div>{{ $subjects->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Mata Pelajaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode / Singkatan <span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="form-control text-uppercase" placeholder="Contoh: MTK, PAI" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Matematika" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Mapel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Import --}}
<div class="modal fade" id="importModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('admin.subjects.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-file-earmark-excel text-success me-1"></i> Import Mata Pelajaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih File Excel</label>
                <input class="form-control" type="file" name="excel_file" accept=".xlsx,.xls,.csv" required>
            </div>
            <div class="alert alert-info py-2 mb-0 small">
                Gunakan template untuk memastikan kolom <code>kode</code>, <code>nama</code>, dan <code>urutan</code> sesuai.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success btn-sm">Proses Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Hidden Form for Single Delete --}}
<form id="deleteSingleForm" action="" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const btnBulkDelete = document.getElementById('btnBulkDelete');
        const bulkSeparator = document.getElementById('bulkSeparator');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAll) {
            selectAll.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateBulkUI();
            });
        }

        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('item-checkbox')) {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
                if (selectAll) selectAll.checked = (checkedCount === checkboxes.length && checkboxes.length > 0);
                updateBulkUI();
            }
        });

        function updateBulkUI() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (selectedCount) selectedCount.innerText = checkedCount;
            if (checkedCount > 0) {
                btnBulkDelete?.classList.remove('d-none');
                bulkSeparator?.classList.remove('d-none');
            } else {
                btnBulkDelete?.classList.add('d-none');
                bulkSeparator?.classList.add('d-none');
            }
        }
    });

    function bulkDelete() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (confirm(`Hapus ${checkedCount} mata pelajaran terpilih secara masal?`)) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    function deleteSingle(id, name) {
        if (confirm(`Hapus mata pelajaran ${name}?`)) {
            const form = document.getElementById('deleteSingleForm');
            form.action = `/admin/subjects/${id}`;
            form.submit();
        }
    }
</script>
@endpush
