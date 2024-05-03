<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbj extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj';
    protected $guarded = ['id'];

    public function pengusul()
    {
        return $this->hasMany(SuratNonPbjPengusul::class, 'surat_non_pbj_id', 'id');
    }

    public function diteruskan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    public function statusAccWadir2()
    {
        if ($this->acc_wadir2 == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_wadir2 == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak <br>' . '( ' . $this->keterangan_wadir2 . ' )';
        }
    }


    public function statusAccPpk()
    {
        if ($this->acc_ppk == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_ppk == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak <br>' . '( ' . $this->keterangan_ppk . ' )';
        }
    }

    public function disposisis()
    {
        return $this->hasMany(SuratNonPbjDisposisi::class, 'surat_non_pbj_id', 'id');
    }

    public function getFile()
    {
        return asset('storage/' . $this->file);
    }

    public function details()
    {
        return $this->hasMany(SuratNonPbjDetail::class);
    }

    public function uang_muka()
    {
        return $this->hasOne(SuratNonPbjUangMuka::class);
    }

    public function spj()
    {
        return $this->hasOne(SuratNonPbjSpj::class);
    }
}
