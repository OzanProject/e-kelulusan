@extends('backend.layouts.app')

@section('title', 'Data Siswa & Nilai')
@section('page_title', 'Data Siswa & Nilai')

@push('css')
<style>
/* ── Wrapper scroll horizontal ── */
.table-students-wrap {
    overflow-x: auto;
    border-radius: 0;
}

/* ── Tabel utama ── */
.table-students {
    font-size: .8rem;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    min-width: 950px;
}

/* ── Sticky header ── */
.table-students thead th {
    position: sticky;
    top: 0;
    background-color: #1d6fac;
    color: #fff;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 6px 8px;
    border: 1px solid #1a6099;
    z-index: 2;
}

/* ── Sticky kolom CHECKBOX + NO + NAMA ── */
.table-students th.col-check,
.table-students td.col-check {
    position: sticky;
    left: 0;
    z-index: 3;
    min-width: 35px;
    text-align: center;
}
.table-students th.col-no,
.table-students td.col-no {
    position: sticky;
    left: 35px;
    z-index: 3;
    min-width: 40px;
    text-align: center;
}
.table-students th.col-nama,
.table-students td.col-nama {
    position: sticky;
    left: 75px;
    z-index: 3;
    min-width: 180px;
    text-align: left;
}
.table-students thead th.col-check,
.table-students thead th.col-no,
.table-students thead th.col-nama { z-index: 4; background-color: #1d6fac; }

.table-students tbody td.col-check,
.table-students tbody td.col-no,
.table-students tbody td.col-nama {
    background-color: #fff;
}
.table-students tbody td.col-nama {
    border-right: 2px solid #dee2e6;
}

.table-students tbody tr:nth-child(even) td.col-check,
.table-students tbody tr:nth-child(even) td.col-no,
.table-students tbody tr:nth-child(even) td.col-nama { background-color: #f8f9fa; }

.table-students tbody tr.row-tidak-lulus td.col-check,
.table-students tbody tr.row-tidak-lulus td.col-no,
.table-students tbody tr.row-tidak-lulus td.col-nama { background-color: #f8d7da; }

/* ── Sticky kolom AKSI ── */
.table-students th.col-aksi,
.table-students td.col-aksi {
    position: sticky;
    right: 0;
    z-index: 3;
    min-width: 80px;
    text-align: center;
    border-left: 2px solid #dee2e6;
}
.table-students thead th.col-aksi { z-index: 4; background-color: #1d6fac; }
.table-students tbody td.col-aksi { background-color: #fff; }
.table-students tbody tr:nth-child(even) td.col-aksi { background-color: #f8f9fa; }
.table-students tbody tr.row-tidak-lulus td.col-aksi { background-color: #f8d7da; }

/* ── Baris data ── */
.table-students tbody tr { transition: background .15s; }
.table-students tbody tr:hover td { background-color: #e8f4fd !important; }
.table-students tbody td {
    padding: 5px 7px;
    vertical-align: middle;
    border: 1px solid #dee2e6;
    white-space: nowrap;
}

/* ── Row tidak lulus ── */
.table-students tbody tr.row-tidak-lulus td { background-color: #fdf0f0; color: #842029; }

/* ── Kolom grup header ── */
.th-grup-mapel  { background-color: #155e8e !important; }
.th-grup-absen  { background-color: #0f4c72 !important; }

/* ── Nilai bagus / kurang ── */
.nilai-tinggi { color: #198754; font-weight: 600; }
.nilai-rendah { color: #dc3545; font-weight: 600; }
.nilai-kosong { color: #adb5bd; }

/* ── TTL ── */
.col-ttl { font-weight: 700; font-size: .85rem; }

/* ── Pagination kecil ── */
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

            <h5 class="mb-0 fw-bold text-primary me-auto">
                <i class="bi bi-table me-1"></i> Daftar Siswa
            </h5>

            {{-- Per-page --}}
            <form method="GET" action="{{ route('admin.students.index') }}" class="d-flex align-items-center gap-2">
                {{-- Preserve existing params --}}
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('direction')) <input type="hidden" name="direction" value="{{ request('direction') }}"> @endif
                
                <span class="text-muted small">Tampilkan</span>
                <select name="per_page" class="form-select form-select-sm"
                        style="width:70px" onchange="this.form.submit()">
                    @foreach([10, 20, 30, 50, 100] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </form>

            <div class="vr mx-1"></div>

            {{-- Sorting --}}
            <form method="GET" action="{{ route('admin.students.index') }}" class="d-flex align-items-center gap-2">
                @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                
                <span class="text-muted small"><i class="bi bi-sort-alpha-down"></i></span>
                <select name="sort_direction" class="form-select form-select-sm"
                        style="width:130px" onchange="window.location.href=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama_lengkap', 'direction' => 'asc']) }}" 
                        {{ $sortBy == 'nama_lengkap' && $direction == 'asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama_lengkap', 'direction' => 'desc']) }}"
                        {{ $sortBy == 'nama_lengkap' && $direction == 'desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'desc']) }}"
                        {{ $sortBy == 'created_at' && $direction == 'desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'asc']) }}"
                        {{ $sortBy == 'created_at' && $direction == 'asc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </form>

            <div class="vr mx-1"></div>

            {{-- Bulk Actions --}}
            <div id="btnBulkGroup" class="d-none d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-info" onclick="bulkPrint()">
                    <i class="bi bi-printer"></i> Cetak SKL (<span id="selectedCount">0</span>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>

            <div class="vr mx-1 d-none" id="bulkSeparator"></div>

            <a href="{{ route('admin.students.export') }}" class="btn btn-sm btn-outline-success no-loader">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export Excel
            </a>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-file-earmark-excel"></i> Import
            </button>
            <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah
            </a>
        </div>
    </div>

    {{-- ── Tabel ── --}}
    <form id="bulkDeleteForm" action="{{ route('admin.students.bulk-delete') }}" method="POST">
        @csrf
        <div class="table-students-wrap">
            <table class="table-students">
                <thead>
                    {{-- Baris 1: grup --}}
                    <tr>
                        <th class="col-check" rowspan="2">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th class="col-no"  rowspan="2">NO</th>
                        <th class="col-nama" rowspan="2">NAMA SISWA</th>
                        <th rowspan="2" style="min-width:110px">NISN</th>
                        <th rowspan="2" style="min-width:95px">NIS</th>
                        @if($subjects->count())
                        <th colspan="{{ $subjects->count() }}" class="th-grup-mapel">MATA PELAJARAN</th>
                        @endif
                        <th rowspan="2" class="col-ttl">TTL</th>
                        <th colspan="3" class="th-grup-absen">KETIDAKHADIRAN</th>
                        <th rowspan="2">EKSKUL<br><small>Pramuka</small></th>
                        <th rowspan="2" style="min-width:90px">STATUS</th>
                        <th class="col-aksi" rowspan="2">AKSI</th>
                    </tr>
                    {{-- Baris 2: sub-header mapel + absen --}}
                    <tr>
                        @foreach($subjects as $s)
                            <th title="{{ $s->nama }}">{{ $s->kode }}</th>
                        @endforeach
                        <th>Skt</th>
                        <th>Izin</th>
                        <th>Alpa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                    @php
                        $ttl      = $student->nilai_ujian['TTL'] ?? 0;
                        $rowClass = $student->status_kelulusan === 'tidak_lulus' ? 'row-tidak-lulus' : '';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="col-check">
                            <input type="checkbox" name="ids[]" value="{{ $student->id }}" class="form-check-input student-checkbox">
                        </td>
                        <td class="col-no text-center">{{ $students->firstItem() + $index }}</td>
                        <td class="col-nama fw-semibold">{{ $student->nama_lengkap }}</td>
                        <td class="text-center">{{ $student->nisn }}</td>
                        <td class="text-center">{{ $student->nomor_peserta }}</td>

                        {{-- Nilai per mapel --}}
                        @foreach($subjects as $s)
                        @php $n = $student->nilai_ujian[$s->kode] ?? null; @endphp
                        <td class="text-center {{ is_numeric($n) ? ($n >= 75 ? 'nilai-tinggi' : 'nilai-rendah') : 'nilai-kosong' }}">
                            {{ is_numeric($n) ? $n : '-' }}
                        </td>
                        @endforeach

                        {{-- TTL --}}
                        <td class="text-center col-ttl {{ $ttl > 0 ? '' : 'nilai-kosong' }}">
                            {{ $ttl > 0 ? $ttl : '-' }}
                        </td>

                        {{-- Ketidakhadiran --}}
                        <td class="text-center">{{ $student->nilai_ujian['Sakit'] ?? 0 }}</td>
                        <td class="text-center">{{ $student->nilai_ujian['Izin'] ?? 0 }}</td>
                        <td class="text-center {{ ($student->nilai_ujian['Alpa'] ?? 0) > 0 ? 'text-danger fw-bold' : '' }}">
                            {{ $student->nilai_ujian['Alpa'] ?? 0 }}
                        </td>

                        {{-- Pramuka --}}
                        <td class="text-center">{{ $student->nilai_ujian['Pramuka'] ?? '-' }}</td>

                        {{-- Status --}}
                        <td class="text-center">
                            @if($student->status_kelulusan === 'lulus')
                                <span class="badge text-bg-success px-2">✓ Lulus</span>
                            @elseif($student->status_kelulusan === 'tidak_lulus')
                                <span class="badge text-bg-danger px-2">✗ Tidak Lulus</span>
                            @else
                                <span class="badge text-bg-warning px-2">⏳ Ditunda</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="col-aksi">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.students.print', $student->id) }}" target="_blank"
                                   class="btn btn-xs btn-info" title="Cetak SKL">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                                <a href="{{ route('admin.students.edit', $student->id) }}"
                                   class="btn btn-xs btn-warning" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="btn btn-xs btn-danger" title="Hapus" onclick="deleteSingle('{{ $student->id }}', '{{ addslashes($student->nama_lengkap) }}')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $subjects->count() + 11 }}" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Data siswa belum tersedia. Silakan
                            <a href="{{ route('admin.students.create') }}">tambah manual</a> atau
                            <a href="#" data-bs-toggle="modal" data-bs-target="#importModal">import Excel</a>.
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
                @if($students->total())
                    Menampilkan <strong>{{ $students->firstItem() }}</strong>–<strong>{{ $students->lastItem() }}</strong>
                    dari <strong>{{ $students->total() }}</strong> siswa
                    &bull; Hal. <strong>{{ $students->currentPage() }}</strong> / <strong>{{ $students->lastPage() }}</strong>
                @else
                    Tidak ada data.
                @endif
            </div>
            <div>{{ $students->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>

</div>

{{-- Hidden Form for Single Delete --}}
<form id="deleteSingleForm" action="" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

{{-- ── Modal Import ── --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="importModalLabel">
                <i class="bi bi-file-earmark-excel text-success me-1"></i> Import Data Siswa
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih File Excel</label>
                <input class="form-control" type="file" name="excel_file"
                       accept=".xlsx,.xls,.csv" required>
                <div class="form-text">Format: .xlsx, .xls, .csv &bull; Maks. 5 MB</div>
            </div>
            <div class="alert alert-info py-2 mb-0 small">
                <i class="bi bi-info-circle me-1"></i>
                Gunakan template yang disediakan agar format kolom sesuai.
                Jika NISN sudah ada, data akan <strong>diperbarui</strong> otomatis.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <a href="{{ route('admin.students.template') }}" class="btn btn-outline-success btn-sm no-loader">
                <i class="bi bi-download"></i> Download Template
            </a>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-upload"></i> Proses Import
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const btnBulkGroup = document.getElementById('btnBulkGroup');
        const bulkSeparator = document.getElementById('bulkSeparator');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAll) {
            selectAll.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.student-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateBulkUI();
            });
        }

        // Delegate event for individual checkboxes
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('student-checkbox')) {
                const checkboxes = document.querySelectorAll('.student-checkbox');
                const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
                
                if (selectAll) {
                    selectAll.checked = (checkedCount === checkboxes.length && checkboxes.length > 0);
                }
                updateBulkUI();
            }
        });

        function updateBulkUI() {
            const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
            if (selectedCount) selectedCount.innerText = checkedCount;
            
            if (checkedCount > 0) {
                btnBulkGroup?.classList.remove('d-none');
                bulkSeparator?.classList.remove('d-none');
            } else {
                btnBulkGroup?.classList.add('d-none');
                bulkSeparator?.classList.add('d-none');
            }
        }
    });

    function bulkDelete() {
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        if (confirm(`Hapus ${checkedCount} data siswa terpilih secara masal?`)) {
            const form = document.getElementById('bulkDeleteForm');
            form.action = "{{ route('admin.students.bulk-delete') }}";
            form.target = "_self";
            form.submit();
        }
    }

    function bulkPrint() {
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        if (confirm(`Cetak SKL untuk ${checkedCount} siswa terpilih?`)) {
            const form = document.getElementById('bulkDeleteForm');
            form.action = "{{ route('admin.students.bulk-print') }}";
            form.target = "_blank"; // Print in new tab
            form.submit();
        }
    }

    function deleteSingle(id, name) {
        if (confirm(`Hapus siswa ${name}?`)) {
            const form = document.getElementById('deleteSingleForm');
            form.action = `/admin/students/${id}`;
            form.target = "_self";
            form.submit();
        }
    }
</script>
@endpush
