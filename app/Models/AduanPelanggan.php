<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanPelanggan extends Model
{
    use HasFactory;

    protected $table = 'aduan_pelanggan';
    protected $guarded = [];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'no_faktur', 'no_faktur');
    }
}
