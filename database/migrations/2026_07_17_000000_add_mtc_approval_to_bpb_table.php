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
        Schema::table('bpb', function (Blueprint $table) {
            $table->tinyInteger('approve_manager')->default(0)->after('approve_head_dept');
            $table->string('approve_user_manager', 10)->nullable()->after('approve_manager');
            $table->dateTime('tgl_approve_manager')->nullable()->after('approve_user_manager');
            $table->tinyInteger('approve_direktur')->default(0)->after('tgl_approve_manager');
            $table->string('approve_user_direktur', 10)->nullable()->after('approve_direktur');
            $table->dateTime('tgl_approve_direktur')->nullable()->after('approve_user_direktur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bpb', function (Blueprint $table) {
            $table->dropColumn([
                'approve_manager',
                'approve_user_manager',
                'tgl_approve_manager',
                'approve_direktur',
                'approve_user_direktur',
                'tgl_approve_direktur'
            ]);
        });
    }
};
