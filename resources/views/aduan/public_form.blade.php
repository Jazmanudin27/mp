<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formulir Pengaduan Pelanggan - Portal Pacific</title>
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
            --input-bg: rgba(15, 23, 42, 0.6);
            --input-border: rgba(255, 255, 255, 0.15);
            --success: #10b981;
            --error: #f43f5e;
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
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Lights */
        .ambient-light-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.15) 0%, transparent 70%);
            top: 10%;
            left: 5%;
            pointer-events: none;
            z-index: 0;
        }

        .ambient-light-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            bottom: 10%;
            right: 5%;
            pointer-events: none;
            z-index: 0;
        }

        .container {
            width: 100%;
            max-width: 650px;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 25px 50px rgba(0, 210, 255, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-wrapper {
            margin-bottom: 15px;
            display: inline-block;
        }

        .logo-icon {
            font-size: 48px;
            color: var(--primary);
            filter: drop-shadow(0 0 10px rgba(0, 210, 255, 0.4));
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        label i {
            color: var(--primary);
            font-size: 16px;
        }

        .input-control {
            width: 100%;
            padding: 14px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 12px;
            color: var(--text-main);
            font-family: inherit;
            font-size: 15px;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 210, 255, 0.15);
            background: rgba(15, 23, 42, 0.85);
        }

        .input-control::placeholder {
            color: #64748b;
        }

        .input-control:disabled {
            background: rgba(15, 23, 42, 0.3);
            color: #64748b;
            border-color: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
        }

        textarea.input-control {
            resize: vertical;
            min-height: 100px;
        }

        select.input-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Custom Photo Upload Grid */
        .photo-upload-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }

        .photo-uploader {
            border: 2px dashed var(--input-border);
            border-radius: 14px;
            height: 110px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
            background: rgba(15, 23, 42, 0.2);
        }

        .photo-uploader:hover {
            border-color: var(--primary);
            background: rgba(0, 210, 255, 0.03);
        }

        .photo-uploader input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .uploader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            pointer-events: none;
        }

        .uploader-content i {
            font-size: 26px;
            color: var(--text-muted);
            margin-bottom: 5px;
            transition: color 0.25s ease;
        }

        .photo-uploader:hover .uploader-content i {
            color: var(--primary);
        }

        .uploader-content span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .photo-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
            z-index: 5;
        }

        .remove-photo-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            background: rgba(244, 63, 94, 0.85);
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            z-index: 15;
            display: none;
            font-size: 12px;
            transition: background 0.2s;
        }

        .remove-photo-btn:hover {
            background: var(--error);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4);
            filter: brightness(1.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Spinner for loading state */
        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Success Screen */
        .success-screen {
            display: none;
            text-align: center;
            padding: 20px 0;
        }

        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.15);
            border: 2px solid var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px auto;
            color: var(--success);
            font-size: 40px;
            animation: scaleIn 0.5s ease-out forwards;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        @keyframes scaleIn {
            0% { transform: scale(0.6); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: white;
        }

        .success-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-done {
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-done:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .error-alert {
            background: rgba(244, 63, 94, 0.1);
            border: 1px solid rgba(244, 63, 94, 0.2);
            color: #fda4af;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .error-alert i {
            font-size: 18px;
            color: var(--error);
            flex-shrink: 0;
        }

        @media (max-width: 576px) {
            .card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            h1 {
                font-size: 20px;
            }

            .photo-upload-grid {
                gap: 10px;
            }

            .photo-uploader {
                height: 95px;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-light-1"></div>
    <div class="ambient-light-2"></div>

    <div class="container">
        <div class="card">
            
            <!-- Alert Error -->
            <div id="errorAlert" class="error-alert">
                <i class="ti ti-alert-triangle"></i>
                <span id="errorMessage">Gagal memproses data. Silakan cek kembali.</span>
            </div>

            <!-- Complaint Form -->
            <form id="complaintForm" method="POST" enctype="multipart/form-data">
                <div class="header">
                    <div class="logo-wrapper">
                        <i class="ti ti-messages-off logo-icon"></i>
                    </div>
                    <h1>Pengaduan Pelanggan</h1>
                    <p class="subtitle">Silakan isi formulir di bawah jika Anda memiliki keluhan</p>
                </div>

                <input type="hidden" name="no_faktur" value="{{ $prefill['no_faktur'] }}">

                <!-- Invoice (Prefilled/ReadOnly if from link) -->
                @if(!empty($prefill['no_faktur']))
                <div class="form-group">
                    <label><i class="ti ti-file-text"></i> Nomor Faktur Terkait</label>
                    <input type="text" class="input-control" value="{{ $prefill['no_faktur'] }}" disabled style="font-weight: 600; color: var(--primary);">
                </div>
                @endif

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama"><i class="ti ti-user"></i> Nama Lengkap <span style="color: var(--error)">*</span></label>
                    <input type="text" id="nama" name="nama" class="input-control" placeholder="Masukkan nama lengkap Anda" value="{{ $prefill['nama'] }}" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat"><i class="ti ti-map-pin"></i> Alamat Toko / Pelanggan <span style="color: var(--error)">*</span></label>
                    <textarea id="alamat" name="alamat" class="input-control" placeholder="Masukkan alamat lengkap" required>{{ $prefill['alamat'] }}</textarea>
                </div>

                <!-- No HP -->
                <div class="form-group">
                    <label for="no_hp"><i class="ti ti-phone"></i> Nomor HP / WhatsApp <span style="color: var(--error)">*</span></label>
                    <input type="tel" id="no_hp" name="no_hp" class="input-control" placeholder="Contoh: 08123456789" value="{{ $prefill['no_hp'] }}" required>
                </div>

                <!-- Jenis Aduan -->
                <div class="form-group">
                    <label for="jenis_aduan"><i class="ti ti-category"></i> Jenis Aduan <span style="color: var(--error)">*</span></label>
                    <select id="jenis_aduan" name="jenis_aduan" class="input-control" required>
                        <option value="" disabled selected>-- Pilih Jenis Pengaduan --</option>
                        <option value="Pelayanan">Pelayanan Salesman / Staff</option>
                        <option value="Pengiriman">Pengiriman Barang Terlambat</option>
                        <option value="Barang Rusak">Barang Rusak / Bad Stock</option>
                        <option value="Tagihan Tidak Sesuai">Tagihan Tidak Sesuai Faktur</option>
                        <option value="Lainnya">Lain-lain / Pengaduan Lainnya</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi"><i class="ti ti-notes"></i> Deskripsi Masalah <span style="color: var(--error)">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" class="input-control" placeholder="Jelaskan detail keluhan atau aduan Anda secara rinci" required></textarea>
                </div>

                <!-- Foto Bukti (Max 3) -->
                <div class="form-group">
                    <label><i class="ti ti-photo"></i> Unggah Foto Bukti (Maksimal 3 Foto)</label>
                    <div class="photo-upload-grid">
                        
                        <!-- Slot 1 -->
                        <div class="photo-uploader" id="uploader-slot-1">
                            <div class="uploader-content" id="uploader-content-1">
                                <i class="ti ti-camera"></i>
                                <span>Foto 1</span>
                            </div>
                            <input type="file" name="foto1" id="file-slot-1" accept="image/*" onchange="previewImage(this, 1)">
                            <img src="" alt="Preview 1" id="preview-1" class="photo-preview">
                            <button type="button" class="remove-photo-btn" id="remove-btn-1" onclick="clearSlot(1)">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>

                        <!-- Slot 2 -->
                        <div class="photo-uploader" id="uploader-slot-2">
                            <div class="uploader-content" id="uploader-content-2">
                                <i class="ti ti-camera"></i>
                                <span>Foto 2</span>
                            </div>
                            <input type="file" name="foto2" id="file-slot-2" accept="image/*" onchange="previewImage(this, 2)">
                            <img src="" alt="Preview 2" id="preview-2" class="photo-preview">
                            <button type="button" class="remove-photo-btn" id="remove-btn-2" onclick="clearSlot(2)">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>

                        <!-- Slot 3 -->
                        <div class="photo-uploader" id="uploader-slot-3">
                            <div class="uploader-content" id="uploader-content-3">
                                <i class="ti ti-camera"></i>
                                <span>Foto 3</span>
                            </div>
                            <input type="file" name="foto3" id="file-slot-3" accept="image/*" onchange="previewImage(this, 3)">
                            <img src="" alt="Preview 3" id="preview-3" class="photo-preview">
                            <button type="button" class="remove-photo-btn" id="remove-btn-3" onclick="clearSlot(3)">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="spinner" id="btnSpinner"></span>
                    <span id="btnText"><i class="ti ti-send"></i> Kirim Pengaduan</span>
                </button>
            </form>

            <!-- Success Screen -->
            <div id="successScreen" class="success-screen">
                <div class="success-icon-wrapper">
                    <i class="ti ti-check"></i>
                </div>
                <h2 class="success-title">Pengaduan Terkirim!</h2>
                <p class="success-desc" id="successDesc">Pengaduan Anda telah terdaftar. Tim kami akan segera meninjau dan menindaklanjui keluhan Anda. Terima kasih.</p>
                <a href="javascript:void(0);" onclick="location.reload();" class="btn-done">Buat Aduan Baru</a>
            </div>

        </div>
    </div>

    <script>
        // Image preview logic
        function previewImage(input, index) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-' + index);
                    const content = document.getElementById('uploader-content-' + index);
                    const removeBtn = document.getElementById('remove-btn-' + index);
                    const slot = document.getElementById('uploader-slot-' + index);

                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    content.style.display = 'none';
                    removeBtn.style.display = 'flex';
                    slot.style.borderColor = 'var(--primary)';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Clear image slot
        function clearSlot(index) {
            const input = document.getElementById('file-slot-' + index);
            const preview = document.getElementById('preview-' + index);
            const content = document.getElementById('uploader-content-' + index);
            const removeBtn = document.getElementById('remove-btn-' + index);
            const slot = document.getElementById('uploader-slot-' + index);

            input.value = ''; // Clear file input
            preview.src = '';
            preview.style.display = 'none';
            content.style.display = 'flex';
            removeBtn.style.display = 'none';
            slot.style.borderColor = 'var(--input-border)';
        }

        // AJAX Submission
        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');

            // Show loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnSpinner.style.display = 'inline-block';
            errorAlert.style.display = 'none';

            const formData = new FormData(form);

            fetch("{{ route('aduan.submit') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 && res.body.success) {
                    // Show success screen
                    form.style.display = 'none';
                    document.getElementById('successDesc').innerText = res.body.message;
                    document.getElementById('successScreen').style.display = 'block';
                } else {
                    // Show validation or process error
                    const msg = res.body.message || 'Gagal memproses data. Silakan cek kembali inputan Anda.';
                    showError(msg);
                }
            })
            .catch(err => {
                showError('Terjadi kesalahan jaringan. Silakan coba beberapa saat lagi.');
            })
            .finally(() => {
                // Reset submit button state
                submitBtn.disabled = false;
                btnText.style.display = 'flex';
                btnSpinner.style.display = 'none';
            });
        });

        function showError(msg) {
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.innerText = msg;
            errorAlert.style.display = 'flex';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
