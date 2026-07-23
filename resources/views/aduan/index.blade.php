@extends('layouts.app')
@section('titlepage', 'Pengaduan Pelanggan')

@section('content')
@section('navigasi')
    <span>Daftar Pengaduan Pelanggan</span>
@endsection

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ti ti-messages me-2 text-primary"></i> Data Pengaduan Pelanggan</h5>
        <small class="text-muted">Keluhan Masuk Dari WhatsApp</small>
    </div>
    
    <!-- Filter Section -->
    <div class="card-body">
        <form method="GET" action="{{ route('aduan.index') }}">
            <div class="row g-3">
                <!-- Date Range -->
                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                </div>

                <!-- Jenis Aduan -->
                <div class="col-md-2">
                    <label class="form-label">Jenis Aduan</label>
                    <select name="jenis_aduan" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="Pelayanan" {{ request('jenis_aduan') == 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                        <option value="Pengiriman" {{ request('jenis_aduan') == 'Pengiriman' ? 'selected' : '' }}>Pengiriman</option>
                        <option value="Barang Rusak" {{ request('jenis_aduan') == 'Barang Rusak' ? 'selected' : '' }}>Barang Rusak</option>
                        <option value="Tagihan Tidak Sesuai" {{ request('jenis_aduan') == 'Tagihan Tidak Sesuai' ? 'selected' : '' }}>Tagihan Tidak Sesuai</option>
                        <option value="Lainnya" {{ request('jenis_aduan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value="DIPROSES" {{ request('status') == 'DIPROSES' ? 'selected' : '' }}>DIPROSES</option>
                        <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
                    </select>
                </div>

                <!-- Keyword -->
                <div class="col-md-2">
                    <label class="form-label">Cari Kata Kunci</label>
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Nama, HP, Faktur..." value="{{ request('keyword') }}">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <!-- Table -->
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal Masuk</th>
                    <th>Nama & No. HP</th>
                    <th>Alamat</th>
                    <th>No. Faktur</th>
                    <th>Jenis Aduan</th>
                    <th>Keluhan / Deskripsi</th>
                    <th>Foto Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($complaints as $complaint)
                    <tr>
                        <td>
                            <span class="fw-medium">{{ $complaint->created_at->format('d/m/Y') }}</span><br>
                            <small class="text-muted">{{ $complaint->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <strong>{{ $complaint->nama }}</strong><br>
                            <small class="text-muted"><i class="ti ti-phone me-1 text-success"></i>{{ $complaint->no_hp }}</small>
                        </td>
                        <td>
                            <div style="max-width: 200px; white-space: normal; line-height: 1.4;">
                                {{ $complaint->alamat }}
                            </div>
                        </td>
                        <td>
                            @if($complaint->no_faktur)
                                <span class="badge bg-label-info">{{ $complaint->no_faktur }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeClass = 'bg-label-secondary';
                                if($complaint->jenis_aduan == 'Pelayanan') $badgeClass = 'bg-label-primary';
                                elseif($complaint->jenis_aduan == 'Pengiriman') $badgeClass = 'bg-label-warning';
                                elseif($complaint->jenis_aduan == 'Barang Rusak') $badgeClass = 'bg-label-danger';
                                elseif($complaint->jenis_aduan == 'Tagihan Tidak Sesuai') $badgeClass = 'bg-label-info';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $complaint->jenis_aduan }}</span>
                        </td>
                        <td>
                            <div style="max-width: 250px; white-space: normal; line-height: 1.4;">
                                {{ $complaint->deskripsi }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @for($i = 1; $i <= 3; $i++)
                                    @php $fotoField = 'foto' . $i; @endphp
                                    @if($complaint->$fotoField)
                                        @php
                                            $photoUrl = Storage::url($complaint->$fotoField);
                                        @endphp
                                        <img src="{{ url($photoUrl) }}" 
                                             alt="Bukti {{ $i }}" 
                                             class="rounded cursor-pointer border hover-shadow" 
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             onclick="openImageModal('{{ url($photoUrl) }}')">
                                    @endif
                                @endfor
                                @if(!$complaint->foto1 && !$complaint->foto2 && !$complaint->foto3)
                                    <span class="text-muted" style="font-size: 12px;">Tanpa Foto</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $statusBadge = 'bg-danger';
                                if($complaint->status == 'DIPROSES') $statusBadge = 'bg-warning';
                                elseif($complaint->status == 'SELESAI') $statusBadge = 'bg-success';
                            @endphp
                            <span class="badge {{ $statusBadge }}">{{ $complaint->status }}</span>
                        </td>
                        <td>
                            <button type="button" 
                                    class="btn btn-sm btn-icon btn-label-secondary" 
                                    onclick="editStatus('{{ $complaint->id }}', '{{ $complaint->status }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Tidak ada data pengaduan pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
            Showing {{ $complaints->firstItem() ?? 0 }} to {{ $complaints->lastItem() ?? 0 }} of {{ $complaints->total() }} entries
        </div>
        <div>
            {{ $complaints->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Image Preview -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 fs-4" data-bs-dismiss="modal" aria-label="Close" style="z-index: 9999;"></button>
                <img src="" id="modalPreviewImg" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Status Aduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Terkini</label>
                        <select name="status" id="modalStatusSelect" class="form-select" required>
                            <option value="PENDING">PENDING</option>
                            <option value="DIPROSES">DIPROSES</option>
                            <option value="SELESAI">SELESAI</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('myscript')
<script>
    // Modal Image Preview trigger
    function openImageModal(url) {
        document.getElementById('modalPreviewImg').src = url;
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    }

    // Modal Edit Status trigger
    function editStatus(id, currentStatus) {
        const form = document.getElementById('editStatusForm');
        form.action = `/aduan-pelanggan/${id}/update-status`;
        document.getElementById('modalStatusSelect').value = currentStatus;
        const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
        modal.show();
    }
</script>
<style>
    .hover-shadow {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-shadow:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
</style>
@endpush
@endsection
