<form action="{{ route('ticket.update', Crypt::encrypt($ticket->kode_pengajuan)) }}" method="POST" id="formTicketEdit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-input-with-icon label="Tanggal Pengajuan" name="tanggal" value="{{ $ticket->tanggal }}" icon="ti ti-calendar" datepicker="flatpickr-date" readonly />
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label class="form-label fw-bold">Tingkat Prioritas</label>
                <select name="priority" id="priority_edit" class="form-select">
                    <option value="Sedang" {{ $ticket->priority == 'Sedang' ? 'selected' : '' }}>Sedang (Normal)</option>
                    <option value="Rendah" {{ $ticket->priority == 'Rendah' ? 'selected' : '' }}>Rendah (Low)</option>
                    <option value="Tinggi" {{ $ticket->priority == 'Tinggi' ? 'selected' : '' }}>Tinggi (High)</option>
                    <option value="Urgent" {{ $ticket->priority == 'Urgent' ? 'selected' : '' }}>Urgent (Immediate)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label fw-bold">Jenis Tiket Ajuan <span class="text-danger">*</span></label>
        <select name="id_kategori" id="id_kategori_edit" class="form-select" required>
            <option value="">-- Pilih Jenis Tiket Ajuan --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $ticket->id_kategori == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <x-input-with-icon label="Judul / Ringkasan Tiket" name="judul" value="{{ $ticket->judul }}" icon="ti ti-heading" required />
    </div>

    <div class="form-group mb-3">
        <x-input-with-icon label="No. Faktur / No. Bukti Transaksi (Opsional / Jika Ada)" name="no_bukti" value="{{ $ticket->no_bukti }}" icon="ti ti-file-description" />
    </div>

    <div class="form-group mb-3">
        <x-textarea label="Detail Keterangan & Alasan Pengajuan" name="keterangan" value="{{ $ticket->keterangan }}" required />
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label class="form-label fw-bold">File Lampiran Dokumen Baru (Opsional)</label>
                <input type="file" name="lampiran" class="form-control" accept=".xlsx,.xls,.doc,.docx,.pdf,.jpg,.jpeg,.png,.zip,.rar">
                @if ($ticket->lampiran)
                    <small class="text-success d-block mt-1"><i class="ti ti-paperclip me-1"></i>Lampiran saat ini: <a href="{{ asset($ticket->lampiran) }}" target="_blank">Unduh Lampiran</a></small>
                @endif
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <x-input-with-icon label="Link URL / Referensi Tambahan" name="link" value="{{ $ticket->link }}" icon="ti ti-link" />
        </div>
    </div>

    <div class="form-group mb-2">
        <button class="btn btn-primary w-100 py-2 fs-6" id="btnUpdate"><i class="ti ti-device-floppy me-1"></i>Update Tiket Ajuan</button>
    </div>
</form>

<script>
    $(function() {
        $(".flatpickr-date").flatpickr();
    });
</script>
