<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaSetting extends Model
{
    use HasFactory;

    protected $table = 'wa_settings';
    protected $guarded = [];
}
