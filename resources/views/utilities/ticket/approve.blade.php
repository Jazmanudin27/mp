<form action="{{ route('ticket.storeapprove', Crypt::encrypt($ticket->kode_pengajuan)) }}" method="POST" id="formApproveTicket">
    @csrf

    {{-- Ticket Information Card --}}
    <div class="card bg-lighter border mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="badge bg-primary font-monospace fs-6 mb-1">{{ $ticket->kode_pengajuan }}</span>
                    <h5 class="fw-bold text-dark mb-0">{{ $ticket->judul ?? 'Pengajuan Tiket' }}</h5>
                </div>
                <div>
                    {!! $ticket->badge_priority !!}
                    {!! $ticket->badge_status !!}
                </div>
            </div>

            <div class="row text-muted small my-2">
                <div class="col-md-4"><strong>Pembuat:</strong> {{ $ticket->user->name ?? '-' }} ({{ $ticket->kode_cabang ?? '-' }} / {{ $ticket->kode_dept ?? '-' }})</div>
                <div class="col-md-4"><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($ticket->tanggal)) }}</div>
                <div class="col-md-4"><strong>Kategori:</strong> {{ $ticket->category->nama_kategori ?? 'Umum' }}</div>
            </div>

            <hr class="my-2">

            <div class="mb-2">
                <label class="fw-bold text-dark small">Keterangan / Detail Pengajuan:</label>
                <div class="p-2 bg-white rounded border small">{{ $ticket->keterangan }}</div>
            </div>

            @if ($ticket->lampiran || $ticket->link)
                <div class="d-flex gap-2 mt-2">
                    @if ($ticket->lampiran)
                        <a href="{{ asset($ticket->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                            <i class="ti ti-paperclip me-1"></i>Unduh File Lampiran
                        </a>
                    @endif
                    @if ($ticket->link)
                        <a href="{{ $ticket->link }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="ti ti-link me-1"></i>Buka Link Referensi
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Approval Stepper Timeline --}}
    <div class="card border mb-3">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0 fw-bold"><i class="ti ti-git-merge me-1 text-primary"></i>Alur Status Persetujuan (Approval Flow)</h6>
        </div>
        <div class="card-body p-3">
            <div class="row text-center align-items-center">
                @if ($ticket->kode_cabang == 'PST')
                    {{-- PST Flow --}}
                    <div class="col-md-6 mb-2">
                        <div class="p-2 rounded border {{ $ticket->manager_approved_at ? 'bg-success-subtle border-success text-success' : ($ticket->posisi_approval == 'MANAGER_DEPT' ? 'bg-warning-subtle border-warning text-warning' : 'bg-light text-muted') }}">
                            <div class="fw-bold">1. Manager Dept</div>
                            <small>{{ $ticket->managerDept->name ?? 'Dept Manager' }}</small><br>
                            @if ($ticket->manager_approved_at)
                                <span class="badge bg-success mt-1"><i class="ti ti-check me-1"></i>Disetujui: {{ date('d/m/Y H:i', strtotime($ticket->manager_approved_at)) }}</span>
                            @elseif($ticket->posisi_approval == 'MANAGER_DEPT' && $ticket->status == '0')
                                <span class="badge bg-warning text-dark mt-1"><i class="ti ti-clock me-1"></i>Menunggu Approval</span>
                            @else
                                <span class="badge bg-secondary mt-1">-</span>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Non-PST Flow --}}
                    <div class="col">
                        <div class="p-2 rounded border {{ $ticket->smm_approved_at ? 'bg-success-subtle border-success text-success' : ($ticket->posisi_approval == 'SMM' ? 'bg-warning-subtle border-warning text-warning' : 'bg-light text-muted') }}">
                            <div class="fw-bold small">1. SMM</div>
                            <small class="d-block text-truncate">{{ $ticket->smmUser->name ?? 'SMM Cabang' }}</small>
                            @if ($ticket->smm_approved_at)
                                <span class="badge bg-success"><i class="ti ti-check me-1"></i>Disetujui</span>
                            @elseif($ticket->posisi_approval == 'SMM' && $ticket->status == '0')
                                <span class="badge bg-warning text-dark"><i class="ti ti-clock me-1"></i>Menunggu</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </div>
                    </div>

                    @if ($ticket->category && $ticket->category->perlu_rsm)
                        <div class="col">
                            <div class="p-2 rounded border {{ $ticket->rsm_approved_at ? 'bg-success-subtle border-success text-success' : ($ticket->posisi_approval == 'RSM' ? 'bg-warning-subtle border-warning text-warning' : 'bg-light text-muted') }}">
                                <div class="fw-bold small">2. RSM</div>
                                <small class="d-block text-truncate">{{ $ticket->rsmUser->name ?? 'RSM Regional' }}</small>
                                @if ($ticket->rsm_approved_at)
                                    <span class="badge bg-success"><i class="ti ti-check me-1"></i>Disetujui</span>
                                @elseif($ticket->posisi_approval == 'RSM' && $ticket->status == '0')
                                    <span class="badge bg-warning text-dark"><i class="ti ti-clock me-1"></i>Menunggu</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($ticket->category && $ticket->category->perlu_gm)
                        <div class="col">
                            <div class="p-2 rounded border {{ $ticket->gm_approved_at ? 'bg-success-subtle border-success text-success' : ($ticket->posisi_approval == 'GM' ? 'bg-warning-subtle border-warning text-warning' : 'bg-light text-muted') }}">
                                <div class="fw-bold small">3. GM</div>
                                <small class="d-block text-truncate">{{ $ticket->gmUser->name ?? 'GM' }}</small>
                                @if ($ticket->gm_approved_at)
                                    <span class="badge bg-success"><i class="ti ti-check me-1"></i>Disetujui</span>
                                @elseif($ticket->posisi_approval == 'GM' && $ticket->status == '0')
                                    <span class="badge bg-warning text-dark"><i class="ti ti-clock me-1"></i>Menunggu</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif

                {{-- IT Exec Final --}}
                <div class="col">
                    <div class="p-2 rounded border {{ $ticket->status == '1' ? 'bg-success-subtle border-success text-success' : ($ticket->posisi_approval == 'ADMIN' && $ticket->status == '0' ? 'bg-primary-subtle border-primary text-primary' : 'bg-light text-muted') }}">
                        <div class="fw-bold small">IT Admin</div>
                        <small class="d-block text-truncate">{{ $ticket->adminUser->name ?? 'Eksekusi IT' }}</small>
                        @if ($ticket->status == '1')
                            <span class="badge bg-success"><i class="ti ti-check me-1"></i>Selesai</span>
                        @elseif($ticket->posisi_approval == 'ADMIN' && $ticket->status == '0')
                            <span class="badge bg-primary"><i class="ti ti-settings me-1"></i>Proses IT</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Decline Notes Input Area --}}
    <div id="declineNotesArea" class="form-group mb-3 d-none">
        <label class="form-label fw-bold text-danger">Alasan Penolakan Tiket <span class="text-danger">*</span></label>
        <textarea name="catatan_decline" id="catatan_decline" class="form-control border-danger" rows="3" placeholder="Masukkan alasan penolakan agar pembuat tiket dapat mengetahui alasannya..."></textarea>
    </div>

    {{-- Action Buttons --}}
    @if ($ticket->status == '0')
        <div class="d-flex gap-2">
            <button type="submit" name="approve" id="btnSubmitApprove" class="btn btn-success flex-grow-1 py-2 fw-bold">
                <i class="ti ti-check me-1"></i>Setujui Pengajuan Tiket
            </button>
            <button type="button" id="btnToggleDecline" class="btn btn-outline-danger py-2 fw-bold">
                <i class="ti ti-x me-1"></i>Tolak (Decline)
            </button>
            <button type="submit" name="decline" id="btnSubmitDecline" class="btn btn-danger py-2 fw-bold d-none">
                <i class="ti ti-x me-1"></i>Konfirmasi Penolakan
            </button>
        </div>
    @else
        <div class="alert alert-secondary text-center mb-0">
            <i class="ti ti-info-circle me-1"></i>Tiket ini sudah memiliki status akhir ({{ $ticket->status == '1' ? 'Selesai' : 'Ditolak' }}).
        </div>
    @endif
</form>

<script>
    $(function() {
        $("#btnToggleDecline").click(function() {
            $("#declineNotesArea").removeClass("d-none");
            $("#btnSubmitApprove").addClass("d-none");
            $(this).addClass("d-none");
            $("#btnSubmitDecline").removeClass("d-none");
            $("#catatan_decline").focus();
        });

        $("#formApproveTicket").submit(function(e) {
            if ($("#btnSubmitDecline").is(":visible") && $("#catatan_decline").val().trim() == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Alasan penolakan wajib diisi!",
                    icon: "warning"
                });
                return false;
            }
        });
    });
</script>
