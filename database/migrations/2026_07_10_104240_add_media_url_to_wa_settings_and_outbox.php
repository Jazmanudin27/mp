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
        if (Schema::hasTable('wa_settings')) {
            Schema::table('wa_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('wa_settings', 'wa_media_url')) {
                    $table->string('wa_media_url')->nullable()->after('wa_message_template');
                }
            });
        }

        if (Schema::hasTable('wa_outbox')) {
            Schema::table('wa_outbox', function (Blueprint $table) {
                if (!Schema::hasColumn('wa_outbox', 'media_url')) {
                    $table->string('media_url')->nullable()->after('message');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('wa_settings')) {
            Schema::table('wa_settings', function (Blueprint $table) {
                if (Schema::hasColumn('wa_settings', 'wa_media_url')) {
                    $table->dropColumn('wa_media_url');
                }
            });
        }

        if (Schema::hasTable('wa_outbox')) {
            Schema::table('wa_outbox', function (Blueprint $table) {
                if (Schema::hasColumn('wa_outbox', 'media_url')) {
                    $table->dropColumn('media_url');
                }
            });
        }
    }
};
