<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSuratPerjalananDinas extends Model
{
    use HasFactory;
    protected $table = 'riwayat_surat_perjalanan_dinas';
    protected $guarded = ['id'];
}
