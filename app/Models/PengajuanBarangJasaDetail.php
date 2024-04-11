<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaDetail extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_barang_jasa_detail';
    protected $guarded = ['id'];

    public function pengajuan_barang_jasa()
    {
        return $this->belongsTo(PengajuanBarangJasa::class);
    }
}
