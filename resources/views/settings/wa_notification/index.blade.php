@extends('layouts.app')
@section('titlepage', 'Pengaturan Notifikasi WhatsApp')

@section('content')
@section('navigasi')
    <span>Pengaturan Notifikasi WhatsApp</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Konfigurasi Gateway & Pesan WA</h5>
                <small class="text-muted float-end">Jadwal Notifikasi Jatuh Tempo</small>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-circle-check me-2 fs-4"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-alert-triangle me-2 fs-4"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('wa-setting.update') }}" method="POST">
                    @csrf
                    
                    <!-- Gateway URL -->
                    <div class="mb-3">
                        <label class="form-label" for="wa_gateway_url">WhatsApp API Gateway URL</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-link"></i></span>
                            <input type="url" id="wa_gateway_url" name="wa_gateway_url" class="form-control" value="{{ old('wa_gateway_url', $setting->wa_gateway_url) }}" placeholder="https://api.fonnte.com/send" required />
                        </div>
                        <div class="form-text">Endpoint URL dari API provider WhatsApp gateway Anda.</div>
                    </div>

                    <!-- API Token -->
                    <div class="mb-3">
                        <label class="form-label" for="wa_api_token">API Token / Authorization Key</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-key"></i></span>
                            <input type="password" id="wa_api_token" name="wa_api_token" class="form-control" value="{{ old('wa_api_token', $setting->wa_api_token) }}" placeholder="Masukkan API Key / Token" />
                        </div>
                        <div class="form-text">Kunci otentikasi token untuk mengakses API gateway.</div>
                    </div>

                    <div class="row">
                        <!-- Days Before Due Date -->
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="scheduled_days_before">Kirim Notifikasi (H- Sebelum Jatuh Tempo)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-calendar-due"></i></span>
                                <input type="number" id="scheduled_days_before" name="scheduled_days_before" class="form-control" value="{{ old('scheduled_days_before', $setting->scheduled_days_before) }}" min="0" required />
                                <span class="input-group-text">Hari</span>
                            </div>
                            <div class="form-text">Berapa hari sebelum tanggal jatuh tempo notifikasi dikirimkan.</div>
                        </div>

                        <!-- Scheduled Time -->
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="scheduled_time">Waktu Pengiriman Harian</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-clock"></i></span>
                                <input type="time" id="scheduled_time" name="scheduled_time" class="form-control" value="{{ old('scheduled_time', $setting->scheduled_time) }}" required />
                            </div>
                            <div class="form-text">Jam berapa notifikasi otomatis dikirimkan ke pelanggan.</div>
                        </div>
                    </div>

                    <!-- Media Banner URL -->
                    <div class="mb-3">
                        <label class="form-label" for="wa_media_url">WhatsApp Media Banner URL (Gambar Banner)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-photo"></i></span>
                            <input type="url" id="wa_media_url" name="wa_media_url" class="form-control" value="{{ old('wa_media_url', $setting->wa_media_url) }}" placeholder="https://contoh.com/banner-tagihan.png" />
                        </div>
                        <div class="form-text">URL gambar untuk dikirim sebagai banner pesan WhatsApp (misal: image tagihan). Kosongkan jika hanya ingin mengirim teks biasa.</div>
                    </div>

                    <!-- Message Template -->
                    <div class="mb-3">
                        <label class="form-label" for="wa_message_template">Templat Pesan WhatsApp</label>
                        <textarea id="wa_message_template" name="wa_message_template" class="form-control" rows="8" placeholder="Masukkan draf teks notifikasi..." required>{{ old('wa_message_template', $setting->wa_message_template) }}</textarea>
                        <div class="form-text">Tulis pesan notifikasi. Anda dapat memformatnya menggunakan tebal (*) atau miring (_).</div>
                    </div>

                    <!-- Status Toggle -->
                    <div class="mb-4">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $setting->is_active ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active" style="font-weight: 500;">Aktifkan Otomatisasi Notifikasi WhatsApp</label>
                        </div>
                        <div class="form-text text-warning"><i class="ti ti-alert-circle me-1"></i> Jika diaktifkan, scheduler Laravel akan otomatis mengirimkan pesan sesuai waktu dan hari yang dikonfigurasi di atas.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Panel -->
    <div class="col-lg-4 col-md-12 col-sm-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="ti ti-info-circle me-1 text-primary"></i> Daftar Placeholder Pesan</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-muted" style="font-size: 13px;">
                    Gunakan kode-kode (placeholders) di bawah ini dalam templat pesan Anda. Sistem akan otomatis mengganti kode tersebut dengan data faktur & pelanggan yang riil saat mengirim pesan.
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="table-light">
                                <th>Kode</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="text-primary">{nama_pelanggan}</code></td>
                                <td>Nama Pelanggan / Toko</td>
                            </tr>
                            <tr>
                                <td><code class="text-primary">{no_faktur}</code></td>
                                <td>Nomor Faktur Pembelian</td>
                            </tr>
                            <tr>
                                <td><code class="text-primary">{tanggal_jatuh_tempo}</code></td>
                                <td>Tanggal Jatuh Tempo Faktur</td>
                            </tr>
                            <tr>
                                <td><code class="text-primary">{sisa_tagihan}</code></td>
                                <td>Jumlah Nominal Sisa Piutang</td>
                            </tr>
                            <tr>
                                <td><code class="text-primary">{link_bayar}</code></td>
                                <td>Link Pembayaran Publik</td>
                            </tr>
                            <tr>
                                <td><code class="text-primary">{link_aduan}</code></td>
                                <td>Link Form Pengaduan Publik</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info mt-3 mb-0" role="alert" style="font-size: 12px; line-height: 1.5;">
                    <strong>Contoh Penggunaan:</strong><br>
                    Yth Bapak/Ibu *{nama_pelanggan}*, tagihan Faktur No *{no_faktur}* sebesar *Rp {sisa_tagihan}* mendekati jatuh tempo pada *{tanggal_jatuh_tempo}*. Mohon segera lakukan pelunasan. Link bayar: {link_bayar}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
