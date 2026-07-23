<?php

namespace App\Http\Controllers;

use App\Models\AduanPelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AduanController extends Controller
{
    /**
     * Public Route: Show the Complaint Form
     */
    public function showForm($encrypted_faktur = null)
    {
        $prefill = [
            'nama' => '',
            'alamat' => '',
            'no_hp' => '',
            'no_faktur' => ''
        ];

        if ($encrypted_faktur) {
            try {
                $no_faktur = Crypt::decryptString($encrypted_faktur);
                $pj = new Penjualan();
                $penjualan = $pj->getFaktur($no_faktur);

                if ($penjualan) {
                    $prefill = [
                        'nama' => $penjualan->nama_pelanggan,
                        'alamat' => $penjualan->alamat_pelanggan,
                        'no_hp' => $penjualan->no_hp_pelanggan,
                        'no_faktur' => $no_faktur
                    ];
                }
            } catch (\Exception $e) {
                // If decryption fails, simply load empty form
            }
        }

        return view('aduan.public_form', compact('prefill', 'encrypted_faktur'));
    }

    /**
     * Public Route: Submit Complaint
     */
    public function submitForm(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'jenis_aduan' => 'required|string',
            'deskripsi' => 'required|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'jenis_aduan.required' => 'Jenis aduan wajib dipilih.',
            'deskripsi.required' => 'Deskripsi aduan wajib diisi.',
            'foto1.image' => 'File harus berupa gambar.',
            'foto1.max' => 'Ukuran gambar maksimal 3MB.',
            'foto2.image' => 'File harus berupa gambar.',
            'foto2.max' => 'Ukuran gambar maksimal 3MB.',
            'foto3.image' => 'File harus berupa gambar.',
            'foto3.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        try {
            $foto_paths = [];
            $destination = 'public/aduan';

            for ($i = 1; $i <= 3; $i++) {
                $fieldName = 'foto' . $i;
                if ($request->hasFile($fieldName)) {
                    $image = $request->file($fieldName);
                    $filename = time() . '_' . $i . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Process Image (Resize & Compress)
                    $img = Image::make($image->getRealPath());
                    $img->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->encode('jpg', 75);

                    // Ensure directory exists and save
                    Storage::put($destination . '/' . $filename, $img);
                    $foto_paths['foto' . $i] = 'aduan/' . $filename;
                } else {
                    $foto_paths['foto' . $i] = null;
                }
            }

            // Create record
            AduanPelanggan::create([
                'no_faktur' => $request->no_faktur,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jenis_aduan' => $request->jenis_aduan,
                'deskripsi' => $request->deskripsi,
                'foto1' => $foto_paths['foto1'],
                'foto2' => $foto_paths['foto2'],
                'foto3' => $foto_paths['foto3'],
                'status' => 'PENDING',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan Anda berhasil dikirim dan akan segera diproses oleh tim kami.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Public Route: Show Invoice & Payment info
     */
    public function showPayment($encrypted_faktur)
    {
        try {
            $no_faktur = Crypt::decryptString($encrypted_faktur);
            $pj = new Penjualan();
            $penjualan = $pj->getFaktur($no_faktur);
            
            if (!$penjualan) {
                abort(404, 'Faktur tidak ditemukan.');
            }

            $piutang_faktur = $pj->getpiutangFaktur($no_faktur)->first();
            $sisa_piutang = $piutang_faktur ? $piutang_faktur->sisa_piutang : 0;
            $detail = $pj->getDetailpenjualan($no_faktur);

            // Get bank accounts config or default bank details
            $bank_rekening = DB::table('keuangan_rekening')->get();

            return view('aduan.public_payment', compact('penjualan', 'sisa_piutang', 'detail', 'bank_rekening', 'encrypted_faktur'));
        } catch (\Exception $e) {
            abort(404, 'Faktur tidak valid atau kedaluwarsa.');
        }
    }

    /**
     * Portal Route: Index of complaints (Requires Auth)
     */
    public function index(Request $request)
    {
        $query = AduanPelanggan::query();

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->dari, $request->sampai]);
        }

        if (!empty($request->jenis_aduan)) {
            $query->where('jenis_aduan', $request->jenis_aduan);
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%")
                  ->orWhere('no_hp', 'like', "%{$keyword}%")
                  ->orWhere('no_faktur', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $complaints = $query->paginate(15);
        $complaints->appends($request->all());

        return view('aduan.index', compact('complaints'));
    }

    /**
     * Portal Route: Update complaint status (Requires Auth)
     */
    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:PENDING,DIPROSES,SELESAI'
        ]);

        try {
            $complaint = AduanPelanggan::findOrFail($id);
            $complaint->update([
                'status' => $request->status
            ]);

            return Redirect::back()->with(messageSuccess('Status Aduan Berhasil Diperbarui'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
