<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panduan_artikel', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->string('judul', 200);
            $table->string('slug', 200)->unique();
            $table->string('icon', 50)->default('📖');
            $table->longText('konten');
            $table->string('deskripsi_singkat', 300)->nullable();
            $table->integer('urutan')->default(0);
            $table->tinyInteger('aktif')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panduan_artikel');
    }
};
