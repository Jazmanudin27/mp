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
        if (!Schema::hasTable('ticket_categories')) {
            Schema::create('ticket_categories', function (Blueprint $table) {
                $table->id();
                $table->string('kode_kategori', 50)->unique();
                $table->string('nama_kategori');
                $table->text('keterangan')->nullable();
                $table->boolean('perlu_manager_dept')->default(true);
                $table->boolean('perlu_smm')->default(true);
                $table->boolean('perlu_rsm')->default(true);
                $table->boolean('perlu_gm')->default(true);
                $table->boolean('wajib_lampiran')->default(false);
                $table->string('template_file')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_categories');
    }
};
