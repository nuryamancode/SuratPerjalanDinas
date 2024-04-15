<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpjBarangJasa extends Model
{
    use HasFactory;
    protected $table = 'spj_barang_jasa';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(SpjBarangJasaDetail::class, 'spj_barang_jasa_id', 'id');
    }
    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }

    public function pelaksanaFormNonPbj()
    {
        return $this->belongsTo(PengajuanBarangJasaPelaksana::class, 'pengajuan_barang_jasa_pelaksana_id', 'id');
    }

    public function acc_ppk()
    {
        if ($this->acc_ppk == 0) {
            return '<span class="badge badge-warning">Menunggu Persetujuan</span>';
        } elseif ($this->acc_ppk == 1) {
            return '<span class="badge badge-success">Disetujui</span>';
        } else {
            return '<span class="badge badge-danger">Ditolak</span>';
        }
    }
}
