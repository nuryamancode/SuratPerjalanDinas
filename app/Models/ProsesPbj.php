<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesPbj extends Model
{
    use HasFactory;
    protected $table = 'proses_pbj';
    protected $guarded = ['id'];

    public function pbj()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pengajuan_barang_jasa_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function tahapan()
    {
        return $this->belongsTo(TahapanPbj::class, 'tahapan_pbj_id', 'id');
    }
}
