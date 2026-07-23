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
        if (!Schema::hasTable('aduan_pelanggan')) {
            Schema::create('aduan_pelanggan', function (Blueprint $table) {
                $table->id();
                $table->string('no_faktur')->nullable();
                $table->string('nama');
                $table->text('alamat');
                $table->string('no_hp');
                $table->string('jenis_aduan');
                $table->text('deskripsi');
                $table->string('foto1')->nullable();
                $table->string('foto2')->nullable();
                $table->string('foto3')->nullable();
                $table->string('status')->default('PENDING'); // PENDING, DIPROSES, SELESAI
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_pelanggan');
    }
};
