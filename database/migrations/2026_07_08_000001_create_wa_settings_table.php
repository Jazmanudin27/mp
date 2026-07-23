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
        if (!Schema::hasTable('wa_settings')) {
            Schema::create('wa_settings', function (Blueprint $table) {
                $table->id();
                $table->string('wa_gateway_url')->nullable();
                $table->string('wa_api_token')->nullable();
                $table->integer('scheduled_days_before')->default(3);
                $table->time('scheduled_time')->default('09:00:00');
                $table->text('wa_message_template')->nullable();
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_settings');
    }
};
