<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaPelaksana extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_barang_jasa_pelaksana';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pengajuan_barang_jasa_id', 'id');
    }

    public function spjFormNonPbj()
    {
        return $this->hasOne(SpjBarangJasa::class, 'pengajuan_barang_jasa_pelaksana_id', 'id');
    }
}
