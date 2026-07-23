<?php

namespace App\Http\Controllers;

use App\Models\WaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WaSettingController extends Controller
{
    public function index()
    {
        // Get the first setting or create a default one
        $setting = WaSetting::firstOrCreate(
            ['id' => 1],
            [
                'wa_gateway_url' => 'https://api.fonnte.com/send',
                'wa_api_token' => '',
                'scheduled_days_before' => 3,
                'scheduled_time' => '09:00:00',
                'wa_message_template' => "Halo *{nama_pelanggan}*,\n\nKami menginformasikan bahwa Faktur No *{no_faktur}* akan jatuh tempo pada *{tanggal_jatuh_tempo}*.\nTotal sisa tagihan Anda sebesar: *Rp {sisa_tagihan}*.\n\nUntuk melakukan pembayaran silakan klik link berikut:\n{link_bayar}\n\nJika ada pertanyaan atau keluhan mengenai tagihan ini, silakan ajukan pengaduan di link berikut:\n{link_aduan}\n\nTerima kasih atas kerja samanya.",
                'is_active' => false,
            ]
        );

        return view('settings.wa_notification.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'wa_gateway_url' => 'required|url',
            'scheduled_days_before' => 'required|integer|min:0',
            'scheduled_time' => 'required',
            'wa_message_template' => 'required',
            'wa_media_url' => 'nullable|url',
        ]);

        try {
            $setting = WaSetting::firstOrCreate(['id' => 1]);
            $setting->update([
                'wa_gateway_url' => $request->wa_gateway_url,
                'wa_api_token' => $request->wa_api_token,
                'scheduled_days_before' => $request->scheduled_days_before,
                'scheduled_time' => $request->scheduled_time,
                'wa_message_template' => $request->wa_message_template,
                'wa_media_url' => $request->wa_media_url,
                'is_active' => $request->has('is_active'),
            ]);

            return Redirect::back()->with(messageSuccess('Pengaturan WhatsApp Berhasil Diperbarui'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
