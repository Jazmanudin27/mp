<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaOutbox extends Model
{
    use HasFactory;

    protected $table = 'wa_outbox';
    protected $guarded = [];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'no_faktur', 'no_faktur');
    }
}
