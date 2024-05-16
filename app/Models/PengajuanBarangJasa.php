<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasa extends Model
{
    use HasFactory;
    protected $table = 'pbj';
    protected $guarded = ['id'];

    public function lampiranpbj()
    {
        return $this->hasMany(LampiranPBJ::class, 'pbj_id', 'id');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id');
    }

    public function pengusul()
    {
        return $this->hasMany(PengajuanBarangJasaPengusul::class, 'pbj_id', 'id');
    }

    public function getFileDokumen()
    {
        return asset('storage/' . $this->dokumen_surat);
    }

    public function disposisi_pbj()
    {
        return $this->hasOne(PengajuanBarangJasaDisposisi::class, 'pbj_id', 'id')->latest();
    }




}
