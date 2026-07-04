<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi & Durasi Penyelesaian Tiket Ajuan IT</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 20px;
        }
        .report-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            max-width: 1200px;
            margin: 0 auto;
        }
        .report-header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .table-report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table-report th {
            background-color: #0f172a;
            color: #ffffff;
            padding: 8px 10px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #0f172a;
        }
        .table-report td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .table-report tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .summary-box {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }
        .badge-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
        }
        .badge-done { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .badge-pending { background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        
        @media print {
            body { background: #fff; padding: 0; }
            .report-card { box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
            .table-report th { background-color: #000 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="report-card">
    {{-- Print Control Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('ticket.index') }}" class="btn btn-secondary btn-sm">
            &larr; Kembali ke Daftar Tiket
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold">
            🖨️ Cetak / Print Laporan PDF
        </button>
    </div>

    {{-- Header --}}
    <div class="report-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-uppercase mb-1" style="color: #0f172a; letter-spacing: 1px;">PACIFIC SYSTEM HELPDESK</h4>
            <h5 class="fw-bold text-secondary mb-0">LAPORAN EVALUASI & LAMA PENYELESAIAN TIKET IT</h5>
        </div>
        <div class="text-end">
            <span class="text-muted d-block">Tanggal Cetak: {{ date('d/m/Y H:i') }}</span>
            <span class="text-muted d-block">Pencetak: {{ auth()->user()->name }} (Super Admin)</span>
        </div>
    </div>

    {{-- Summary Statistics --}}
    <div class="summary-box">
        <div class="row text-center">
            <div class="col">
                <span class="text-muted fw-bold text-uppercase d-block small">Total Tiket</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($tickets->count()) }}</h4>
            </div>
            <div class="col">
                <span class="text-muted fw-bold text-uppercase d-block small">Selesai (Done)</span>
                <h4 class="fw-bold text-success mb-0">{{ number_format($tickets->where('status', '1')->count()) }}</h4>
            </div>
            <div class="col">
                <span class="text-muted fw-bold text-uppercase d-block small">Menunggu (Pending)</span>
                <h4 class="fw-bold text-warning mb-0">{{ number_format($tickets->where('status', '0')->count()) }}</h4>
            </div>
            <div class="col">
                <span class="text-muted fw-bold text-uppercase d-block small">Ditolak</span>
                <h4 class="fw-bold text-danger mb-0">{{ number_format($tickets->where('status', '2')->count()) }}</h4>
            </div>
        </div>
    </div>

    {{-- Report Table --}}
    <table class="table-report">
        <thead>
            <tr>
                <th style="width: 3%">NO</th>
                <th style="width: 10%">NO. TIKET</th>
                <th style="width: 8%">TANGGAL</th>
                <th style="width: 14%">KATEGORI</th>
                <th>JUDUL & KETERANGAN</th>
                <th style="width: 12%">PENGAJU (USER)</th>
                <th style="width: 6%">CABANG</th>
                <th style="width: 10%">TGL SELESAI</th>
                <th style="width: 12%">LAMA PENYELESAIAN</th>
                <th style="width: 10%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $d)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $d->kode_pengajuan }}</td>
                    <td>{{ date('d/m/Y', strtotime($d->tanggal)) }}</td>
                    <td>{{ $d->category->nama_kategori ?? 'Umum' }}</td>
                    <td>
                        <strong class="d-block text-dark">{{ $d->judul }}</strong>
                        @if ($d->no_bukti)
                            <small class="text-muted d-block">No. Bukti: {{ $d->no_bukti }}</small>
                        @endif
                        <small class="text-muted">{{ Str::limit($d->keterangan, 70) }}</small>
                    </td>
                    <td>
                        <strong class="d-block">{{ formatName2($d->user->name ?? '-') }}</strong>
                        <small class="text-muted">{{ $d->kode_dept }}</small>
                    </td>
                    <td class="text-center fw-bold">{{ $d->kode_cabang }}</td>
                    <td class="text-center">
                        @if ($d->status == '1')
                            {{ date('d/m/Y H:i', strtotime($d->updated_at)) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="fw-bold text-primary">
                        {{ $d->lama_penyelesaian }}
                    </td>
                    <td class="text-center">
                        @if ($d->status == '1')
                            <span class="badge-status badge-done">SELESAI</span>
                        @elseif($d->status == '2')
                            <span class="badge-status badge-rejected">DITOLAK</span>
                        @else
                            <span class="badge-status badge-pending">MENUNGGU</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-4">Tidak ada data tiket untuk kriteria ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer Signature --}}
    <div class="row mt-5 pt-3">
        <div class="col-8">
            <small class="text-muted">* Laporan ini dibuat secara otomatis dari Sistem IT Helpdesk Pacific.</small>
        </div>
        <div class="col-4 text-center">
            <p class="mb-5">Mengetahui,<br><strong>IT Manager / Super Admin</strong></p>
            <p class="mt-4"><u>({{ auth()->user()->name }})</u></p>
        </div>
    </div>
</div>

</body>
</html>
