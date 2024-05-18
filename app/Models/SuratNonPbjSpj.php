<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjSpj extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_spj';
    protected $guarded = ['id'];

    public function suratNonPbj()
    {
        return $this->belongsTo(SuratNonPbj::class, 'surat_non_pbj_id', 'id');
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(SuratNonPbjSpjDetail::class, 'surat_non_pbj_spj_id', 'id');
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
    public function status()
    {
        if ($this->acc_ppk == 0) {
            return 'Menunggu Persetujuan';
        } elseif ($this->acc_ppk == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak';
        }
    }
}
