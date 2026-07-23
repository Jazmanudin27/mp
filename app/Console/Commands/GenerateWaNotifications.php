<?php

namespace App\Console\Commands;

use App\Models\Penjualan;
use App\Models\WaSetting;
use App\Models\WaOutbox;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class GenerateWaNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:generate-notifications {--faktur= : Nomor faktur spesifik untuk ditest} {--force : Abaikan status non-aktif sistem}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate WhatsApp payment due notifications into outbox queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting WhatsApp notification generation...');

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

        // 2. Fetch specific invoice or calculate target due date
        $fakturOpt = $this->option('faktur');
        $query = Penjualan::select('marketing_penjualan.*', 'pelanggan.nama_pelanggan', 'pelanggan.no_hp_pelanggan')
            ->join('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan');

        if ($fakturOpt) {
            $query->where('marketing_penjualan.no_faktur', $fakturOpt);
            $this->info("Searching for invoice: {$fakturOpt}");
        } else {
            $daysBefore = $setting->scheduled_days_before;
            $targetDueDate = Carbon::today()->addDays($daysBefore)->toDateString();
            $this->info("Searching for credit invoices due on: {$targetDueDate} (H-{$daysBefore})");
            $query->where('marketing_penjualan.jenis_transaksi', 'K')
                ->where('marketing_penjualan.status_batal', 0)
                ->whereDate('marketing_penjualan.jatuh_tempo', $targetDueDate);
        }

        $invoices = $query->get();

        if ($invoices->isEmpty()) {
            if ($fakturOpt) {
                $this->error("Invoice {$fakturOpt} not found or customer details are missing.");
            } else {
                $this->info('No invoices match the due date criteria for today.');
            }
            return 0;
        }

        $generatedCount = 0;

        foreach ($invoices as $invoice) {
            $no_faktur = $invoice->no_faktur;
            
            // Calculate sisa piutang (debt)
            $pj = new Penjualan();
            $piutang_faktur = $pj->getpiutangFaktur($no_faktur)->first();
            $sisa_piutang = $piutang_faktur ? $piutang_faktur->sisa_piutang : 0;

            if ($sisa_piutang <= 0 && !$fakturOpt) {
                $this->info("Invoice {$no_faktur} is already fully paid. Skipping.");
                continue;
            }

            // Set dummy amount for testing if paid/zero
            if ($sisa_piutang <= 0) {
                $sisa_piutang = 150000; // Rp 150.000 dummy for testing
            }

            // Check if phone number is valid
            $phone = preg_replace('/[^0-9]/', '', $invoice->no_hp_pelanggan);
            if (empty($phone) || strlen($phone) < 9 || $invoice->no_hp_pelanggan === 'NA') {
                $this->warn("Invoice {$no_faktur} has invalid phone number: '{$invoice->no_hp_pelanggan}'. Skipping.");
                continue;
            }

            // Format phone to international (starts with 62)
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }

            // Check if already generated for this invoice today (skip check if targeting specific faktur)
            if (!$fakturOpt) {
                $exists = WaOutbox::where('no_faktur', $no_faktur)
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if ($exists) {
                    $this->info("Invoice {$no_faktur} already queued today. Skipping.");
                    continue;
                }
            }

            // 4. Build notification links (encrypted for security)
            $encryptedFaktur = Crypt::encryptString($no_faktur);
            $linkBayar = route('aduan.payment', ['encrypted_faktur' => $encryptedFaktur]);
            $linkAduan = route('aduan.form', ['encrypted_faktur' => $encryptedFaktur]);

            // 5. Populate message template
            $placeholders = [
                '{nama_pelanggan}' => $invoice->nama_pelanggan,
                '{no_faktur}' => $no_faktur,
                '{tanggal_jatuh_tempo}' => Carbon::parse($invoice->jatuh_tempo)->format('d-m-Y'),
                '{sisa_tagihan}' => number_format($sisa_piutang, 0, ',', '.'),
                '{link_bayar}' => $linkBayar,
                '{link_aduan}' => $linkAduan,
            ];

            $message = str_replace(array_keys($placeholders), array_values($placeholders), $setting->wa_message_template);

            // 6. Insert into Outbox
            WaOutbox::create([
                'no_faktur' => $no_faktur,
                'no_hp' => $phone,
                'message' => $message,
                'media_url' => $setting->wa_media_url,
                'status' => 'PENDING',
            ]);

            $generatedCount++;
        }

        $this->info("Completed. Generated {$generatedCount} notifications in outbox queue.");
        return 0;
    }
}
