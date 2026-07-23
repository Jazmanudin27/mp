<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tagihan Faktur {{ $penjualan->no_faktur }} - Portal Pacific</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #001a3d 100%);
            --primary: #00d2ff;
            --primary-hover: #00b4db;
            --secondary: #6366f1;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.45);
            --card-border: rgba(255, 255, 255, 0.08);
            --success: #10b981;
            --error: #f43f5e;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px 15px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Lights */
        .ambient-light-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.12) 0%, transparent 70%);
            top: 5%;
            left: 5%;
            pointer-events: none;
            z-index: 0;
        }

        .ambient-light-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            bottom: 5%;
            right: 5%;
            pointer-events: none;
            z-index: 0;
        }

        .container {
            width: 100%;
            max-width: 750px;
            z-index: 10;
            position: relative;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 25px;
            margin-bottom: 30px;
            gap: 20px;
        }

        .logo-section h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-section .brand-name {
            font-size: 13px;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta .faktur-number {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .invoice-meta .faktur-date {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Customer Section */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-block {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 18px;
        }

        .info-block h3 {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 12px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-block h3 i {
            color: var(--primary);
            font-size: 16px;
        }

        .info-block p {
            font-size: 14px;
            line-height: 1.5;
            color: #cbd5e1;
        }

        .info-block .cust-name {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        /* Overview tags */
        .overview-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .bill-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(0, 210, 255, 0.1) 100%);
            border: 1px solid rgba(0, 210, 255, 0.2);
            border-radius: 18px;
            padding: 22px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .bill-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .bill-card .bill-title {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .bill-card .bill-amount {
            font-size: 26px;
            font-weight: 700;
            color: white;
            text-shadow: 0 0 10px rgba(0, 210, 255, 0.2);
        }

        .due-card {
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.15) 0%, rgba(245, 158, 11, 0.1) 100%);
            border: 1px solid rgba(244, 63, 94, 0.2);
            border-radius: 18px;
            padding: 22px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .due-card .due-title {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #fca5a5;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .due-card .due-date {
            font-size: 20px;
            font-weight: 700;
            color: #ffe4e6;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 35px;
        }

        .items-section h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .items-section h3 i {
            color: var(--primary);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
        }

        th {
            background: rgba(15, 23, 42, 0.5);
            padding: 14px 16px;
            font-weight: 600;
            color: var(--primary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .item-qty {
            font-weight: 500;
            color: white;
        }

        /* Bank Transfer Details */
        .bank-section {
            background: rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 35px;
        }

        .bank-section h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            color: white;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .bank-section h3 i {
            color: var(--success);
        }

        .bank-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .bank-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .bank-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .bank-logo {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary);
            font-size: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .bank-details .bank-name {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 3px;
        }

        .bank-details .acc-no {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary);
            font-family: monospace;
            letter-spacing: 0.5px;
        }

        .bank-details .acc-holder {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .btn-copy {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }

        .btn-copy:hover {
            background: rgba(0, 210, 255, 0.1);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Action Buttons */
        .actions-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            padding: 14px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-aduan {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #f59e0b;
        }

        .btn-aduan:hover {
            background: rgba(245, 158, 11, 0.2);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);
            transform: translateY(-2px);
        }

        .btn-contact {
            background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 255, 0.35);
            filter: brightness(1.1);
        }

        /* Toast Popup Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: rgba(16, 185, 129, 0.95);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 14px;
            z-index: 999;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        @media (max-width: 576px) {
            .card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .invoice-meta {
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .overview-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .actions-row {
                grid-template-columns: 1fr;
            }

            .bank-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .btn-copy {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-light-1"></div>
    <div class="ambient-light-2"></div>

    <div class="container">
        <div class="card">
            
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <h1>Portal Pelanggan</h1>
                    <span class="brand-name">Pacific Group</span>
                </div>
                <div class="invoice-meta">
                    <div class="faktur-number">
                        <i class="ti ti-file-invoice"></i> Faktur: {{ $penjualan->no_faktur }}
                    </div>
                    <div class="faktur-date">
                        Tanggal: {{ date('d F Y', strtotime($penjualan->tanggal)) }}
                    </div>
                </div>
            </div>

            <!-- Overview Tagihan -->
            <div class="overview-row">
                <div class="bill-card">
                    <span class="bill-title">Sisa Tagihan</span>
                    <span class="bill-amount">Rp {{ number_format($sisa_piutang, 0, ',', '.') }}</span>
                </div>
                <div class="due-card">
                    <span class="due-title">Jatuh Tempo</span>
                    <span class="due-date">{{ date('d F Y', strtotime($penjualan->jatuh_tempo)) }}</span>
                </div>
            </div>

            <!-- Customer & Sales Information -->
            <div class="info-grid">
                <div class="info-block">
                    <h3><i class="ti ti-building-store"></i> Data Pelanggan</h3>
                    <p class="cust-name">{{ $penjualan->nama_pelanggan }}</p>
                    <p>{{ $penjualan->alamat_toko }}</p>
                    <p>No. HP: {{ $penjualan->no_hp_pelanggan }}</p>
                </div>
                <div class="info-block">
                    <h3><i class="ti ti-user-check"></i> Salesman & Cabang</h3>
                    <p style="font-weight: 500; color: white;">Salesman: {{ $penjualan->nama_salesman }}</p>
                    <p>Cabang: {{ $penjualan->nama_cabang }}</p>
                    <p>{{ $penjualan->alamat_cabang }}</p>
                </div>
            </div>

            <!-- Invoice Itemized Breakdown -->
            <div class="items-section">
                <h3><i class="ti ti-list-details"></i> Rincian Pembelian</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th style="text-align: center;">Jumlah (Dus/Pack/Pcs)</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_bruto = 0;
                            @endphp
                            @forelse($detail as $item)
                                @php
                                    $total_bruto += $item->subtotal;
                                    // Parse qty Dus/Pack/Pcs
                                    $qty_str = '';
                                    if ($item->jumlah > 0) {
                                        $dus = floor($item->jumlah / $item->isi_pcs_dus);
                                        $sisa_dus = $item->jumlah % $item->isi_pcs_dus;
                                        
                                        $pack = 0;
                                        $pcs = $sisa_dus;
                                        if ($item->isi_pcs_pack > 0) {
                                            $pack = floor($sisa_dus / $item->isi_pcs_pack);
                                            $pcs = $sisa_dus % $item->isi_pcs_pack;
                                        }

                                        $parts = [];
                                        if ($dus > 0) $parts[] = $dus . ' Dus';
                                        if ($pack > 0) $parts[] = $pack . ' Pack';
                                        if ($pcs > 0) $parts[] = $pcs . ' Pcs';
                                        $qty_str = implode(', ', $parts);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td style="text-align: center;" class="item-qty">{{ $qty_str }}</td>
                                    <td style="text-align: right; color: white; font-weight: 500;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: var(--text-muted);">Tidak ada data barang.</td>
                                </tr>
                            @endforelse
                            <!-- Summary row -->
                            <tr style="background: rgba(15, 23, 42, 0.4); font-weight: 600;">
                                <td colspan="2" style="text-align: right; color: var(--primary);">Total Belanja:</td>
                                <td style="text-align: right; color: white;">Rp {{ number_format($total_bruto, 0, ',', '.') }}</td>
                            </tr>
                            @if($penjualan->potongan > 0)
                            <tr style="font-weight: 500;">
                                <td colspan="2" style="text-align: right; color: var(--error);">Potongan:</td>
                                <td style="text-align: right; color: var(--error);">- Rp {{ number_format($penjualan->potongan, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($penjualan->potongan_istimewa > 0)
                            <tr style="font-weight: 500;">
                                <td colspan="2" style="text-align: right; color: var(--error);">Potongan Istimewa:</td>
                                <td style="text-align: right; color: var(--error);">- Rp {{ number_format($penjualan->potongan_istimewa, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($penjualan->ppn > 0)
                            <tr style="font-weight: 500;">
                                <td colspan="2" style="text-align: right; color: var(--primary);">PPN:</td>
                                <td style="text-align: right; color: var(--primary);">+ Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bank Transfer Rekening -->
            <div class="bank-section">
                <h3><i class="ti ti-credit-card"></i> Pilihan Bank Transfer Pembayaran</h3>
                <div class="bank-grid">
                    @forelse($bank_rekening as $bank)
                        <div class="bank-card">
                            <div class="bank-info">
                                <div class="bank-logo">{{ strtoupper(substr($bank->nama_bank, 0, 3)) }}</div>
                                <div class="bank-details">
                                    <div class="bank-name">{{ $bank->nama_bank }}</div>
                                    <div class="acc-no" id="acc-no-{{ $bank->id_rekening }}">{{ $bank->no_rekening }}</div>
                                    <div class="acc-holder">a.n. {{ $bank->pemilik_rekening }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('{{ $bank->no_rekening }}')">
                                <i class="ti ti-copy"></i> Salin No.
                            </button>
                        </div>
                    @empty
                        <!-- Default Fallbacks if table is empty -->
                        <div class="bank-card">
                            <div class="bank-info">
                                <div class="bank-logo">BCA</div>
                                <div class="bank-details">
                                    <div class="bank-name">Bank Central Asia (BCA)</div>
                                    <div class="acc-no">123-456-7890</div>
                                    <div class="acc-holder">a.n. PT Pacific Food Indonesia</div>
                                </div>
                            </div>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('123-456-7890')">
                                <i class="ti ti-copy"></i> Salin No.
                            </button>
                        </div>
                        <div class="bank-card">
                            <div class="bank-info">
                                <div class="bank-logo">MDR</div>
                                <div class="bank-details">
                                    <div class="bank-name">Bank Mandiri</div>
                                    <div class="acc-no">987-654-3210</div>
                                    <div class="acc-holder">a.n. PT Pacific Food Indonesia</div>
                                </div>
                            </div>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('987-654-3210')">
                                <i class="ti ti-copy"></i> Salin No.
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Action buttons -->
            <div class="actions-row">
                <a href="{{ route('aduan.form', ['encrypted_faktur' => $encrypted_faktur]) }}" class="btn btn-aduan">
                    <i class="ti ti-messages-off"></i> Ada Aduan / Kendala?
                </a>
                <a href="https://wa.me/{{ !empty($penjualan->telepon_cabang) ? preg_replace('/[^0-9]/', '', $penjualan->telepon_cabang) : '628123456789' }}" target="_blank" class="btn btn-contact">
                    <i class="ti ti-brand-whatsapp"></i> Hubungi Kantor Cabang
                </a>
            </div>

        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i class="ti ti-circle-check"></i> Nomor rekening berhasil disalin!
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('toast');
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 2500);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>
