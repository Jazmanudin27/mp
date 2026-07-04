<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'kode_kategori' => 'PERBAIKAN',
                'nama_kategori' => 'Perbaikan (Bug Fix / System Repair)',
                'keterangan' => 'Pengajuan perbaikan error, bug sistem, atau kendala operasional aplikasi.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => false,
                'wajib_lampiran' => false,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERMINTAAN_USER',
                'nama_kategori' => 'Permintaan User (Support / Assistance)',
                'keterangan' => 'Bantuan teknis, reset password, atau bantuan penggunaan sistem.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => false,
                'wajib_lampiran' => false,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PENAMBAHAN_MENU',
                'nama_kategori' => 'Permintaan Penambahan Menu / Fitur',
                'keterangan' => 'Pengajuan pengembangan modul baru, penambahan menu, atau penyesuaian laporan.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => false,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERPINDAHAN_DATA',
                'nama_kategori' => 'Permintaan Perpindahan Data (Data Migration)',
                'keterangan' => 'Pengajuan perpindahan data pelanggan, salesman, atau transaksi antar cabang/wilayah.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => 'templates/template_perpindahan_data.txt',
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERUBAHAN_DATA_PENJUALAN',
                'nama_kategori' => 'Perubahan Data Transaksi Penjualan',
                'keterangan' => 'Koreksi atau perubahan data faktur/transaksi penjualan.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERUBAHAN_DATA_PEMBAYARAN',
                'nama_kategori' => 'Perubahan Data Transaksi Pembayaran',
                'keterangan' => 'Koreksi atau perubahan data pembayaran/pelunasan piutang.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERUBAHAN_DATA_RETUR',
                'nama_kategori' => 'Perubahan Data Transaksi Retur',
                'keterangan' => 'Koreksi atau perubahan data retur penjualan/barang.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERUBAHAN_DATA_DPB',
                'nama_kategori' => 'Perubahan Data Transaksi DPB',
                'keterangan' => 'Koreksi atau perubahan data DPB (Daftar Penyerahan Barang).',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => null,
                'is_active' => true,
            ],
            [
                'kode_kategori' => 'PERUBAHAN_DATA_MUTASI',
                'nama_kategori' => 'Perubahan Data Mutasi Persediaan',
                'keterangan' => 'Koreksi atau perubahan data mutasi barang/stok persediaan gudang.',
                'perlu_manager_dept' => true,
                'perlu_smm' => true,
                'perlu_rsm' => true,
                'perlu_gm' => true,
                'wajib_lampiran' => true,
                'template_file' => null,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            TicketCategory::updateOrCreate(
                ['kode_kategori' => $cat['kode_kategori']],
                $cat
            );
        }
    }
}
