<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaPengusul extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_barang_jasa_pengusul';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pengajuan_barang_jasa_id', 'id');
    }
}
