<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'id_kategori')) {
                $table->unsignedBigInteger('id_kategori')->nullable()->after('tanggal');
            }
            if (!Schema::hasColumn('tickets', 'judul')) {
                $table->string('judul')->nullable()->after('id_kategori');
            }
            if (!Schema::hasColumn('tickets', 'priority')) {
                $table->string('priority', 20)->default('Sedang')->after('keterangan');
            }
            if (!Schema::hasColumn('tickets', 'lampiran')) {
                $table->string('lampiran')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('tickets', 'kode_cabang')) {
                $table->string('kode_cabang', 10)->nullable()->after('id_user');
            }
            if (!Schema::hasColumn('tickets', 'kode_dept')) {
                $table->string('kode_dept', 10)->nullable()->after('kode_cabang');
            }
            if (!Schema::hasColumn('tickets', 'id_manager_dept')) {
                $table->unsignedBigInteger('id_manager_dept')->nullable()->after('kode_dept');
            }
            if (!Schema::hasColumn('tickets', 'manager_approved_at')) {
                $table->dateTime('manager_approved_at')->nullable()->after('id_manager_dept');
            }
            if (!Schema::hasColumn('tickets', 'id_smm')) {
                $table->unsignedBigInteger('id_smm')->nullable()->after('manager_approved_at');
            }
            if (!Schema::hasColumn('tickets', 'smm_approved_at')) {
                $table->dateTime('smm_approved_at')->nullable()->after('id_smm');
            }
            if (!Schema::hasColumn('tickets', 'id_rsm')) {
                $table->unsignedBigInteger('id_rsm')->nullable()->after('smm_approved_at');
            }
            if (!Schema::hasColumn('tickets', 'rsm_approved_at')) {
                $table->dateTime('rsm_approved_at')->nullable()->after('id_rsm');
            }
            if (!Schema::hasColumn('tickets', 'id_gm')) {
                $table->unsignedBigInteger('id_gm')->nullable()->after('rsm_approved_at');
            }
            if (!Schema::hasColumn('tickets', 'gm_approved_at')) {
                $table->dateTime('gm_approved_at')->nullable()->after('id_gm');
            }
            if (!Schema::hasColumn('tickets', 'posisi_approval')) {
                $table->string('posisi_approval', 30)->default('ADMIN')->after('status');
            }
            if (!Schema::hasColumn('tickets', 'catatan_decline')) {
                $table->text('catatan_decline')->nullable()->after('posisi_approval');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $columns = [
                'id_kategori', 'judul', 'priority', 'lampiran',
                'kode_cabang', 'kode_dept', 'id_manager_dept', 'manager_approved_at',
                'id_smm', 'smm_approved_at', 'id_rsm', 'rsm_approved_at',
                'id_gm', 'gm_approved_at', 'posisi_approval', 'catatan_decline'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('tickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
