<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerjalananDinas extends Model
{
    use HasFactory;
    protected $table = 'surat_perjalanan_dinas';
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    public function details()
    {
        return $this->hasMany(SuratPerjalananDinasDetail::class, 'surat_perjalanan_dinas_id', 'id');
    }

    public function tujuan_disposisi()
    {
        return $this->belongsTo(Karyawan::class, 'disposisi_karyawan_id', 'id');
    }

    public function disposisi()
    {
        return $this->hasOne(Disposisi::class, 'surat_perjalanan_dinas_id', 'id')->latest();
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatSuratPerjalananDinas::class, 'surat_perjalanan_dinas_id', 'id');
    }

    public function scopeNotActive($val)
    {
        $val->where('status', 0)->orWhere('status', NULL);
    }

    public function scopeActive($val)
    {
        $val->where('status', 1);
    }

    public function scopeAcc($val)
    {
        $val->where('validasi_pemberangkatan', 1);
    }

    public function scopeGetByKaryawan($val)
    {
        $val->whereHas('details', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        });
    }
}
