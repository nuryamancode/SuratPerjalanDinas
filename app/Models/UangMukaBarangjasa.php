<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangMukaBarangjasa extends Model
{
    use HasFactory;
    protected $table = 'uang_muka_barang_jasa';
    protected $guarded = ['id'];

    public function barang_jasa()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pengajuan_barang_jasa_id', 'id');
    }
}
