<?php

namespace App\Console\Commands;

use App\Models\WaOutbox;
use App\Models\WaSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessWaOutbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:process-outbox {--force : Abaikan status non-aktif sistem}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the oldest pending WhatsApp notification from the outbox queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Fetch WA Settings
        $setting = WaSetting::first();
        if (!$setting) {
            $this->error('WhatsApp settings not found.');
            return 1;
        }

        if (!$setting->is_active && !$this->option('force')) {
            $this->warn('WhatsApp Auto-Notification is currently inactive. Use --force to run anyway.');
            return 0;
        }

        if (empty($setting->wa_gateway_url) || empty($setting->wa_api_token)) {
            $this->error('WhatsApp API URL or Token is missing in settings.');
            return 1;
        }

        // 2. Fetch oldest pending message
        $outbox = WaOutbox::where('status', 'PENDING')
            ->orderBy('id', 'asc')
            ->first();

        if (!$outbox) {
            $this->info('No pending notifications in the outbox queue.');
            return 0;
        }

        $this->info("Processing outbox ID {$outbox->id} for invoice {$outbox->no_faktur} to {$outbox->no_hp}...");

        // Increment attempts
        $outbox->increment('attempts');

        // 3. Send request to WhatsApp API Gateway
        try {
            $payload = [
                'to' => $outbox->no_hp,
                'message' => $outbox->message,
            ];

            if (!empty($outbox->media_url)) {
                $payload['mediaUrl'] = $outbox->media_url;
            }

            $response = Http::withHeaders([
                'X-API-Key' => $setting->wa_api_token
            ])->post($setting->wa_gateway_url, $payload);

            Log::info("WA Outbox ID {$outbox->id} API Response: " . $response->body());

            if ($response->successful()) {
                $outbox->update([
                    'status' => 'SENT',
                    'sent_at' => now(),
                    'error_message' => null
                ]);
                $this->info("Successfully sent outbox ID {$outbox->id}.");
            } else {
                $outbox->update([
                    'status' => 'FAILED',
                    'error_message' => 'API Error: ' . $response->status() . ' - ' . $response->body()
                ]);
                $this->error("Failed to send outbox ID {$outbox->id}. Gateway returned error.");
            }
        } catch (\Exception $e) {
            Log::error("Error processing WA outbox ID {$outbox->id}: " . $e->getMessage());
            $outbox->update([
                'status' => 'FAILED',
                'error_message' => 'Exception: ' . $e->getMessage()
            ]);
            $this->error("Exception caught: " . $e->getMessage());
        }

        return 0;
    }
}
