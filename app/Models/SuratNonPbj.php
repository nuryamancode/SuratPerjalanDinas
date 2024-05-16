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

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id');
    }

    public function getFileDokumen()
    {
        return asset('storage/' . $this->dokumen_surat);
    }

    public function disposisi_snpbj()
    {
        return $this->hasOne(SuratNonPbjDisposisi::class, 'snpbj_id', 'id')->latest();
    }
    public function lampiransnpbj()
    {
        return $this->hasMany(LampiranSNPBJ::class, 'snpbj_id', 'id');
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
