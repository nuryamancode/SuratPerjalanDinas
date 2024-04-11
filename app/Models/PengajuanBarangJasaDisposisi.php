<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaDisposisi extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_barang_jasa_disposisi';
    protected $guarded = ['id'];

    public function tujuan()
    {
        return $this->belongsTo(Karyawan::class, 'tujuan_karyawan_id', 'id');
    }

    public function pembuat()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_karyawan_id', 'id');
    }

    public function pengajuan_barang_jasa()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pengajuan_barang_jasa_id', 'id');
    }
}
