<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanduanSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate first to prevent duplicate entries on re-run
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('panduan_artikel')->truncate();
        DB::table('panduan_qa')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed Articles (BPB, Pelanggan, & Gudang Cabang)
        DB::table('panduan_artikel')->insert([
            [
                'kategori' => 'Gudang Logistik',
                'judul' => 'Panduan Pengajuan Barang (BPB)',
                'slug' => 'panduan-bpb',
                'icon' => '📋',
                'deskripsi_singkat' => 'Pelajari cara mengajukan permintaan barang ke Gudang Logistik mulai dari input detail hingga serah terima barang.',
                'konten' => '
                    <h5 class="fw-bold mb-3">Langkah-langkah Pengajuan BPB (Bukti Permintaan Barang)</h5>
                    <p>Setiap departemen yang membutuhkan barang dari Gudang Logistik wajib membuat pengajuan secara online melalui menu BPB.</p>
                ',
                'urutan' => 0,
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'Data Master',
                'judul' => 'Panduan Fitur Data Master Pelanggan',
                'slug' => 'panduan-master-pelanggan',
                'icon' => '👥',
                'deskripsi_singkat' => 'Panduan lengkap cara menginput data pelanggan baru, melakukan pencarian / filter, serta mencetak & mengunduh (export) data pelanggan ke Excel.',
                'konten' => '
                    <h5 class="fw-bold mb-3">Pengelolaan Database Pelanggan &amp; Limit Piutang</h5>
                    <p>Halaman Pelanggan digunakan untuk memelihara data referensi toko/pelanggan yang mencakup koordinat rute kunjungan salesmen, foto tempat usaha, serta ketentuan plafon limit kredit belanja mereka.</p>
                    
                    <h6 class="fw-bold text-primary mt-4 mb-2">1. Cara Penginputan (Input) Pelanggan Baru</h6>
                    <p class="text-muted small">Untuk menambahkan pelanggan baru, klik tombol <b>+ Tambah Pelanggan</b> di halaman utama lalu lengkapi form berikut:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Identitas Diri:</b> Isi NIK, KK, Nama Pelanggan, Tanggal Lahir, Alamat Pelanggan, dan Alamat Toko secara lengkap.</li>
                        <li><b>Nomor HP:</b> Masukkan nomor telepon aktif untuk notifikasi penagihan WA. Jika pelanggan tidak memiliki HP, centang kotak <b>NA</b> di samping input untuk mengunci nilai kolom menjadi "NA".</li>
                        <li><b>Delegasi Cabang &amp; Rute Sales:</b> Pilih Cabang operasional. Pilihan Salesman dan Rute Wilayah akan menyesuaikan otomatis.</li>
                        <li><b>Jadwal Kunjungan (Hari):</b> Centang hari kunjungan sales. <span class="text-danger fw-bold">Penting: Setiap pelanggan maksimal hanya boleh dipilih 2 hari kunjungan dalam seminggu.</span></li>
                        <li><b>Limit Kredit &amp; LJT:</b> Atur besaran limit rupiah piutang toko serta Lama Jatuh Tempo (LJT) pembayaran (14, 30, atau 45 hari).</li>
                        <li><b>GPS Lokasi &amp; Foto Toko (Wajib):</b> Masukkan koordinat Latitude &amp; Longitude serta unggah foto fisik toko tampak depan agar salesmen dapat Check-In di aplikasi mobile SFA.</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">2. Fitur Pencarian &amp; Penyaringan (Filter)</h6>
                    <p class="text-muted small">Gunakan bilah filter di halaman utama Pelanggan untuk mencari data spesifik:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Filter Tanggal (Dari &amp; Sampai):</b> Membatasi pencarian berdasarkan tanggal registrasi pelanggan.</li>
                        <li><b>Status Aktif/Nonaktif:</b> Menyortir hanya pelanggan yang berstatus Aktif atau Non-Aktif saja.</li>
                        <li><b>Cabang &amp; Salesman:</b> Membatasi pencarian berdasarkan wilayah cabang atau salesmen yang memegang rute toko tersebut.</li>
                        <li><b>Pencarian Cepat:</b> Ketik kode unik atau nama pelanggan pada input pencarian lalu tekan tombol Cari (ikon kaca pembesar).</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">3. Cetak &amp; Export Excel</h6>
                    <p class="text-muted small">Anda dapat menarik laporan data pelanggan secara fisik maupun digital:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Tombol Excel (Export):</b> Klik tombol **Excel** (berwarna hijau) untuk mengunduh seluruh data pelanggan hasil filter saat itu dalam format file Excel `.xlsx`.</li>
                        <li><b>Tombol Cetak:</b> Klik tombol **Cetak** (berwarna biru) untuk mencetak dokumen daftar pelanggan dalam format printable PDF di tab baru.</li>
                        <li><b>Tombol Nonaktifkan:</b> Tombol ini dapat digunakan secara massal untuk menonaktifkan pelanggan terpilih yang sudah tidak aktif berbelanja.</li>
                    </ul>
                ',
                'urutan' => 1,
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'Gudang Cabang',
                'judul' => 'Panduan Lengkap Operasional Gudang Cabang',
                'slug' => 'panduan-gudang-cabang-lengkap',
                'icon' => '🏬',
                'deskripsi_singkat' => 'Panduan alur kerja stok Gudang Cabang (Saldo Awal, Surat Jalan & Transit In, DPB Loading & Sales, Pengelolaan Bad Stock, Repack, Kirim Pusat, Penyesuaian, dan Laporan).',
                'konten' => '
                    <h5 class="fw-bold mb-3">Siklus Kerja Manajemen Gudang Cabang</h5>
                    <p>Gudang Cabang berfungsi mengelola persediaan barang baik (Good Stock) dan rusak (Bad Stock) di level regional cabang, memproses distribusi muatan tim sales, serta mencatat rekonsiliasi akhir.</p>

                    <h6 class="fw-bold text-primary mt-4 mb-2">1. Saldo Awal Gudang Cabang</h6>
                    <p class="text-muted small">Mencatat stok pembuka di awal bulan berjalan:</p>
                    <ul class="small text-muted mb-3">
                        <li>Buka menu <b>Gudang Cabang &gt; Saldo Awal</b>. Klik <b>+ Buat Saldo Awal</b>.</li>
                        <li>Pilih <b>Bulan</b>, <b>Tahun</b>, dan <b>Kondisi Stok</b> (Good Stock atau Bad Stock).</li>
                        <li>Klik <b>Get Saldo</b> untuk menarik data produk, lalu masukkan kuantitas fisik (Dus, Pack, Pcs). Klik <b>Submit</b>.</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">2. Penerimaan Kiriman Pusat (Surat Jalan &amp; Transit In)</h6>
                    <p class="text-muted small">Penerimaan barang jadi dari Gudang Pusat ke Cabang:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Surat Jalan (SJ):</b> Dokumen pengiriman barang yang diterbitkan oleh Gudang Jadi Pusat.</li>
                        <li><b>Transit In (TI):</b> Halaman konfirmasi cabang. Cari nomor Surat Jalan di menu <b>Transit In</b>, periksa kecocokan fisik barang, isi <b>Tanggal Transit IN</b>, lalu klik <b>Submit</b>. Status SJ akan berubah menjadi "Diterima Cabang" dan stok Good Stock cabang bertambah.</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">3. DPB (Daftar Permintaan / Pengambilan Barang)</h6>
                    <p class="text-muted small">Mengelola muatan salesman keliling yang mencakup beberapa sub-fitur di dalamnya:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Buat DPB (Pengambilan):</b> Input data no DPB, tanggal ambil, nama salesman, kendaraan (no polisi), tujuan, driver, helper (1, 2, 3), dan jumlah pengambilan barang (Dus, Pack, Pcs).</li>
                        <li><b>Kembali DPB (Pengembalian &amp; Penjualan):</b> Ketika salesman kembali dari lapangan, lakukan **Edit DPB** untuk memasukkan tanggal kembali, jumlah barang kembali (sisa), serta jumlah barang keluar/terjual.</li>
                        <li><b>Mutasi DPB (Di Dalam Detail DPB):</b> Terdapat tombol **Tambah Data Mutasi** untuk mencatat transaksi pendukung sales di jalan:
                            <br>- <i>RT</i> (Retur Toko) / <i>HK</i> (Hutang Kirim) / <i>PT</i> (Penyesuaian Toko) -> menambah stok di tangan sales.
                            <br>- <i>PJ</i> (Penjualan) / <i>GB</i> (Ganti Barang) / <i>PH</i> (Promosi Hadiah) / <i>TR</i> (Transit) / <i>PR</i> (Promosi) -> mengurangi stok sales.
                        </li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">4. Pengelolaan Reject, Repack, &amp; Kirim Pusat</h6>
                    <p class="text-muted small">Penanganan barang rusak (Bad Stock/BS) di gudang cabang:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Reject (RG, RM, RP):</b> Pencatatan barang bagus menjadi rusak. Mengurangi Good Stock (`O`) dan menambah Bad Stock (`I`). Terdiri dari: <i>RG</i> (Reject Gudang), <i>RM</i> (Reject Mobil sales), dan <i>RP</i> (Reject Pasar/kembalian toko).</li>
                        <li><b>Repack (RK):</b> Pengemasan ulang barang rusak. Mengurangi Bad Stock (`O`) dan mengembalikan ke Good Stock (`I`) setelah dirapikan.</li>
                        <li><b>Kirim Pusat (KP):</b> Mengirimkan barang rusak (Bad Stock) yang menumpuk di cabang kembali ke pabrik/Gudang Pusat. Mengurangi Bad Stock cabang (`O`).</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">5. Penyesuaian Stok (PY / PB)</h6>
                    <p class="text-muted small">Sinkronisasi selisih sistem dengan fisik opname:</p>
                    <ul class="small text-muted mb-3">
                        <li>Pilih jenis penyesuaian: <b>PY</b> (Penyesuaian Good Stock) atau <b>PB</b> (Penyesuaian Bad Stock).</li>
                        <li>Pilih arah penyesuaian: <b>In</b> (menambah stok) atau <b>Out</b> (mengurangi stok).</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">6. Cetak Laporan Gudang Cabang (5 Pilihan Laporan)</h6>
                    <ul class="small text-muted mb-3">
                        <li><b>Lap. Persediaan GS:</b> Buku mutasi harian barang baik per produk (saldo awal, mutasi masuk/keluar, saldo akhir).</li>
                        <li><b>Lap. Persediaan BS:</b> Buku mutasi harian barang rusak per produk.</li>
                        <li><b>Rekap Persediaan:</b> Rekapitulasi bulanan total stok awal, mutasi masuk, mutasi keluar, dan stok akhir seluruh produk.</li>
                        <li><b>Mutasi DPB:</b> Laporan rincian muatan awal, retur, terjual, dan sisa kembalian per salesman.</li>
                        <li><b>Rekonsiliasi BJ:</b> Mencocokkan data persediaan fisik barang jadi di cabang dengan data transaksi penjualan untuk memastikan kesamaan laporan.</li>
                    </ul>
                ',
                'urutan' => 2,
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'Marketing',
                'judul' => 'Panduan Manajemen Program & Laporan Marketing',
                'slug' => 'panduan-marketing',
                'icon' => '📈',
                'deskripsi_singkat' => 'Pelajari pengelolaan program promosi / ikatan, penambahan target pelanggan, approval pengajuan, pencairan reward, serta penarikan laporan analisis marketing.',
                'konten' => '
                    <h5 class="fw-bold mb-3">Manajemen Program Marketing &amp; Laporan Analisis</h5>
                    <p>Menu Marketing digunakan untuk mengelola program promosi/ikatan untuk pelanggan, melakukan approval pengajuan program, memproses pencairan rewards, serta menarik berbagai laporan operasional dan kinerja penjualan salesmen.</p>

                    <h6 class="fw-bold text-primary mt-4 mb-2">1. Pengajuan Program Ikatan (Ajuan Program)</h6>
                    <p class="text-muted small">Program Ikatan adalah komitmen promosi berjangka (seperti program bulanan atau 6 bulanan) dengan pelanggan toko:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Buat Pengajuan:</b> Masuk ke menu <b>Marketing &gt; Ajuan Program Ikatan</b>, klik <b>+ Buat Pengajuan</b>. Isi detail program, target volume/value, serta periode berlakunya program.</li>
                        <li><b>Tambah Pelanggan Target:</b> Setelah draft pengajuan dibuat, tambahkan pelanggan-pelanggan yang diikutsertakan dalam program tersebut beserta target masing-masing toko.</li>
                        <li><b>Proses Approval:</b> Pengajuan program yang telah diajukan membutuhkan persetujuan (approval) bertingkat dari OM (Operational Manager) atau pihak berwenang sebelum program dinyatakan aktif.</li>
                        <li><b>Cetak Kesepakatan:</b> Setelah disetujui, cetak dokumen Surat Kesepakatan Bersama (SKB) untuk ditandatangani oleh pelanggan sebagai bukti komitmen program.</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">2. Pencairan Program Ikatan (Reward Liquidation)</h6>
                    <p class="text-muted small">Pencairan reward / bonus ketika target program ikatan pelanggan telah tercapai:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Pengajuan Pencairan:</b> Akses menu <b>Marketing &gt; Pencairan Program</b>. Pilih nomor pengajuan program yang sudah selesai masa berlakunya.</li>
                        <li><b>Validasi Pencapaian:</b> Sistem akan menampilkan data realisasi penjualan toko dibandingkan dengan target yang telah disepakati. Jika pencapaian memenuhi syarat, input nilai reward yang akan dicairkan.</li>
                        <li><b>Approval Pencairan:</b> Pengajuan pencairan harus disetujui oleh atasan agar dana/barang reward dapat direalisasikan ke pelanggan.</li>
                    </ul>

                    <h6 class="fw-bold text-primary mt-4 mb-2">3. Cetak Laporan Marketing (Komprehensif)</h6>
                    <p class="text-muted small">Menu Laporan Marketing menyediakan analisis data penjualan dan performa tim di lapangan:</p>
                    <ul class="small text-muted mb-3">
                        <li><b>Laporan Penjualan &amp; Omset:</b> Menampilkan total penjualan, retur barang, kartu piutang pelanggan, dan rincian omset per toko/wilayah.</li>
                        <li><b>Analisa SFA &amp; Aktivitas Lapangan:</b> Memantau kepatuhan salesmen menggunakan SFA (Sales Force Automation), persentase kunjungan (Effective Call), serta log aktivitas harian SMM (Sales Marketing Manager) &amp; RSM (Regional Sales Manager).</li>
                        <li><b>Perhitungan Komisi &amp; Insentif:</b> Menghitung secara otomatis besaran komisi bulanan untuk Salesmen, Driver, dan Helper berdasarkan pencapaian target kirim/jual.</li>
                    </ul>
                ',
                'urutan' => 3,
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed Q&A Database (BPB, Pelanggan, & Gudang Cabang)
        DB::table('panduan_qa')->insert([
            [
                'pertanyaan' => 'Bagaimana cara membuat BPB baru?',
                'jawaban' => 'Cara membuat BPB baru:<br>1. Masuk ke menu <b>Gudang Logistik &gt; BPB</b>.<br>2. Klik tombol <b>+ Buat BPB</b> di kanan atas.<br>3. Pilih barang dari daftar, masukkan jumlah yang diinginkan, dan tulis keterangan.<br>4. Klik tombol <b>Tambah</b> untuk memasukkan ke tabel.<br>5. Centang kotak persetujuan <b>"Yakin Akan Disimpan?"</b> di bawah, lalu klik <b>Submit</b>.',
                'kata_kunci' => 'buat bpb, bikin bpb, tambah bpb, input bpb, cara bpb, ngajuin bpb, pengajuan bpb',
                'kategori' => 'Gudang Logistik',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Kenapa barang pengajuan BPB saya belum diserahkan?',
                'jawaban' => 'Barang BPB belum diserahkan biasanya karena <b>belum disetujui (approve)</b> oleh atasan atau admin gudang. Pastikan status approval di detail BPB Anda sudah lengkap (Head Departemen dan Admin Gudang Logistik sudah memberikan persetujuan). Jika sudah disetujui tapi belum dikirim, silakan konfirmasi ke petugas Gudang Logistik.',
                'kata_kunci' => 'belum diserahkan, bpb belum dikirim, bpb pending, belum approve, bpb belum disetujui, lama bpb',
                'kategori' => 'Gudang Logistik',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Apa bedanya BPB biasa dengan BPB Pembelian?',
                'jawaban' => 'Perbedaan utamanya:<br>- <b>BPB Biasa:</b> Digunakan oleh departemen untuk meminta barang yang tersedia di stok Gudang Logistik (barang keluar).<br>- <b>BPB Pembelian (BPPB):</b> Digunakan oleh Gudang Logistik untuk mengajukan pembelian barang ke supplier luar melalui Bagian Pembelian karena stok di gudang habis (barang masuk).',
                'kata_kunci' => 'beda bpb, bpb pembelian, bpb biasa, bpb vs bpb pembelian, bppb',
                'kategori' => 'Sistem',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara cetak bukti BPB atau BPPB?',
                'jawaban' => 'Untuk mencetak dokumen bukti:<br>1. Buka detail pengajuan BPB/BPPB yang ingin dicetak.<br>2. Jika statusnya sudah di-approve dan Anda memiliki hak akses cetak, tombol <b>Cetak</b> akan muncul di bagian header informasi detail.<br>3. Klik tombol tersebut untuk membuka halaman cetak berformat PDF/Printable.',
                'kata_kunci' => 'cetak bpb, print bpb, cetak bppb, download bpb, cetak bukti',
                'kategori' => 'Sistem',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara memfilter data pelanggan berdasarkan sales atau cabang?',
                'jawaban' => 'Untuk memfilter pelanggan:<br>1. Masuk ke halaman <b>Data Master &gt; Pelanggan</b>.<br>2. Pada panel filter di atas tabel, pilih kriteria seperti **Cabang** atau nama **Salesman**.<br>3. Anda juga bisa memfilter berdasarkan rentang tanggal registrasi (Dari &amp; Sampai), status (Aktif/Nonaktif), maupun pencarian nama/kode.<br>4. Klik tombol **Cari** (ikon kaca pembesar) untuk menyegarkan data.',
                'kata_kunci' => 'filter pelanggan, cari pelanggan, filter sales, cari sales, pelanggan sales, filter cabang',
                'kategori' => 'Data Master',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara mendownload atau export data pelanggan ke Excel?',
                'jawaban' => 'Cara export data pelanggan ke Excel:<br>1. Buka menu <b>Data Master &gt; Pelanggan</b>.<br>2. Terapkan filter terlebih dahulu di form pencarian jika Anda hanya ingin mengunduh data cabang atau status tertentu.<br>3. Klik tombol **Excel** (warna hijau) di pojok kanan atas form pencarian.<br>4. Sistem akan mengunduh berkas `.xlsx` yang berisi seluruh data identitas, sales, limit, dan status pelanggan aktif secara otomatis.',
                'kata_kunci' => 'export pelanggan, download pelanggan, excel pelanggan, download excel, export excel',
                'kategori' => 'Data Master',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Kenapa saya tidak bisa mencentang lebih dari 2 hari kunjungan untuk pelanggan?',
                'jawaban' => 'Sistem membatasi jadwal kunjungan salesman ke setiap toko <b>maksimal hanya 2 hari dalam seminggu</b> untuk efisiensi rute dan pemerataan jadwal visit salesman. Jika Anda memilih 3 hari atau lebih, sistem akan membatalkan centang tersebut otomatis.',
                'kata_kunci' => 'hari kunjungan, jadwal visit, 2 hari, batas hari, visit sales, jadwal sales',
                'kategori' => 'Data Master',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Apa akibatnya jika titik koordinat lokasi pelanggan tidak diisi?',
                'jawaban' => 'Jika titik koordinat (Latitude &amp; Longitude) dikosongkan, salesman <b>tidak akan bisa melakukan check-in</b> kunjungan ke toko tersebut di aplikasi mobile SFA. Salesman akan mendapatkan error lokasi terlalu jauh dari titik koordinat terdaftar.',
                'kata_kunci' => 'titik koordinat, koordinat pelanggan, gps toko, checkin sfa, sfa koordinat, latitude longitude',
                'kategori' => 'Data Master',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara mendaftarkan pelanggan jika mereka tidak punya nomor HP?',
                'jawaban' => 'Jika pelanggan tidak memiliki nomor HP aktif, cukup **centang kotak NA (Not Available)** di sebelah kanan input No. HP. Sistem akan otomatis mengisi kolom tersebut dengan nilai \'NA\' dan mengunci inputnya.',
                'kata_kunci' => 'tidak punya no hp, tidak ada hp, no hp na, na no hp',
                'kategori' => 'Data Master',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara melakukan Transit In untuk kiriman pusat?',
                'jawaban' => 'Langkah Transit In:<br>1. Buka menu <b>Gudang Cabang &gt; Transit In</b>.<br>2. Cari nomor Surat Jalan pengiriman pusat yang masuk ke cabang Anda.<br>3. Klik tombol detail/penerimaan, verifikasi fisik barang.<br>4. Isi <b>Tanggal Transit IN</b> dan klik **Submit**. Sistem otomatis menambah stok Good Stock cabang.',
                'kata_kunci' => 'transit in, terima barang pusat, konfirmasi kiriman, surat jalan masuk, terima sj, sj masuk',
                'kategori' => 'Gudang Cabang',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Apa saja fitur yang ada di dalam menu DPB?',
                'jawaban' => 'Fitur di dalam menu DPB:<br>- <b>Buat DPB (Loading Ambil):</b> Mencatat barang awal yang dibawa sales harian beserta driver/helper dan no polisi kendaraan.<br>- <b>Kembali DPB (Bongkar Sisa):</b> Menginput barang kembali/sisa dan mencatat otomatis penjualan bersih sales.<br>- <b>Detail &amp; Mutasi DPB:</b> Di dalam detail DPB, Anda dapat mencatat mutasi sales jalanan seperti Retur (RT), Hutang Kirim (HK), Promosi (PR), dan Penjualan (PJ).',
                'kata_kunci' => 'fitur dpb, fungsi dpb, isi dpb, detail dpb, mutasi dpb, helper dpb, kembali dpb',
                'kategori' => 'Gudang Cabang',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Apa bedanya Reject (RG, RM, RP), Repack (RK), dan Kirim Pusat (KP)?',
                'jawaban' => 'Beda penanganan Bad Stock:<br>- <b>Reject (RG/RM/RP):</b> Memindahkan barang bagus menjadi barang rusak (misal: reject gudang, reject mobil, reject pasar).<br>- <b>Repack (RK):</b> Memperbaiki kemasan barang rusak agar bagus kembali (Bad Stock keluar, Good Stock masuk).<br>- <b>Kirim Pusat (KP):</b> Mengirimkan barang rusak dari cabang kembali ke pabrik pusat (Bad Stock keluar).',
                'kata_kunci' => 'reject repack kirim pusat, bad stock cabang, barang rusak, reject gudang, repack barang, kirim pusat',
                'kategori' => 'Gudang Cabang',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana melakukan penyesuaian stok (adjusment) gudang cabang?',
                'jawaban' => '1. Masuk menu <b>Gudang Cabang &gt; Penyesuaian</b>. Klik <b>+ Tambah Data</b>.<br>2. Pilih jenis penyesuaian: **PY** (Good Stock) atau **PB** (Bad Stock).<br>3. Tentukan arah **In** (menambah) atau **Out** (mengurangi).<br>4. Isi daftar produk dan kuantitas penyesuaian. Klik **Submit**.',
                'kata_kunci' => 'penyesuaian stok, adjusment cabang, py pb, stock opname cabang, selisih stok',
                'kategori' => 'Gudang Cabang',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Apa saja jenis laporan yang ada di Gudang Cabang?',
                'jawaban' => 'Ada 5 jenis laporan Gudang Cabang:<br>1. **Lap. Persediaan GS:** Mutasi harian barang baik (Good Stock).<br>2. **Lap. Persediaan BS:** Mutasi harian barang rusak (Bad Stock).<br>3. **Rekap Persediaan:** Ringkasan stok bulanan (stok awal, masuk, keluar, sisa).<br>4. **Mutasi DPB:** Laporan pengambilan, penjualan, dan setoran sisa per salesman.<br>5. **Rekonsiliasi BJ:** Rekonsiliasi pencocokan barang jadi cabang antara fisik vs penjualan.',
                'kata_kunci' => 'laporan gudang cabang, jenis laporan gc, persediaan gs, persediaan bs, rekap persediaan, mutasi dpb, rekonsiliasi bj',
                'kategori' => 'Gudang Cabang',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara mengajukan Program Ikatan baru untuk pelanggan?',
                'jawaban' => 'Cara pengajuan Program Ikatan:<br>1. Masuk ke menu <b>Marketing &gt; Ajuan Program Ikatan</b> (atau Ajuan Program 6 Bulan sesuai jenis program).<br>2. Klik tombol <b>+ Buat Pengajuan</b> dan isi form periode serta ketentuan program.<br>3. Setelah pengajuan terbentuk, klik detail lalu klik <b>+ Tambah Pelanggan</b> untuk memasukkan daftar toko peserta beserta target penjualannya.<br>4. Minta approval ke Operational Manager (OM) agar status pengajuan disetujui.',
                'kata_kunci' => 'buat program ikatan, pengajuan program, ajuan program, program marketing, tambah pelanggan program, target program',
                'kategori' => 'Marketing',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana cara mencairkan reward Program Ikatan pelanggan?',
                'jawaban' => 'Langkah pencairan program:<br>1. Buka menu <b>Marketing &gt; Pencairan Program</b>.<br>2. Cari nomor pengajuan program yang ingin dicairkan.<br>3. Periksa kolom realisasi vs target pelanggan. Jika target tercapai, masukkan jumlah reward/insentif yang berhak diterima pelanggan.<br>4. Simpan dan tunggu proses approval pencairan oleh pihak berwenang agar reward dapat diserahkan.',
                'kata_kunci' => 'cairkan program, pencairan program, reward program, bonus program, klaim reward, realisasi target',
                'kategori' => 'Marketing',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Di mana saya bisa melihat performa kunjungan salesmen di lapangan?',
                'jawaban' => 'Performa kunjungan salesmen dapat dipantau melalui:<br>1. Menu <b>Marketing &gt; Laporan Marketing</b>.<br>2. Pilih jenis laporan <b>Effective Call</b> atau <b>Persentase SFA</b>.<br>3. Filter berdasarkan tanggal, cabang, dan nama salesmen yang ingin dianalisis.<br>4. Klik tombol <b>Cetak</b> untuk mengunduh laporan PDF/Excel.',
                'kata_kunci' => 'kunjungan sales, performa sales, effective call, sfa sales, monitor sales, sfa tracker',
                'kategori' => 'Marketing',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pertanyaan' => 'Bagaimana sistem menghitung komisi salesmen, driver, dan helper?',
                'jawaban' => 'Komisi dihitung otomatis oleh sistem berdasarkan data pengiriman dan realisasi penjualan bersih di lapangan. Anda dapat mencetaknya lewat menu <b>Marketing &gt; Laporan Marketing</b> lalu pilih laporan <b>Komisi Salesman</b> atau <b>Komisi Driver Helper</b>, tentukan bulan/tahun periode laporan, lalu klik cetak.',
                'kata_kunci' => 'hitung komisi, komisi sales, komisi driver, komisi helper, gaji sales, insentif driver',
                'kategori' => 'Marketing',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
