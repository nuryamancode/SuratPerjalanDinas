<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPDPelaksana extends Model
{
    use HasFactory;
    protected $table = 'spd_pelaksana_dinas';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function spd()
    {
        return $this->belongsTo(SuratPerjalananDinas::class, 'surat_perjalanan_dinas_id','id');
    }


    public function spj()
    {
        return $this->hasOne(SPJPelaksana::class, 'spd_detail_id', 'id');
    }

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }

    public function scopeGetByKaryawan($val)
    {
        $val->where('karyawan_id', auth()->user()->karyawan->id);
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         if (!$model->uuid) {
    //             $model->uuid = \Str::uuid();
    //         }
    //     });
    // }

    public function uang_muka()
    {
        return $this->hasOne(UangMuka::class, 'spd_pelaksana_dinas_id', 'id');
    }

    public function statusUangMuka()
    {
        if ($this->uang_muka) {
            return 'Sudah Didistribusikan';
        } else {
            return 'Belum Didistribusikan';
        }
    }
    public function status()
    {
        if ($this->spj && $this->spj->status == 1) {
            return 'Disetujui';
        } elseif ($this->spj && $this->spj->status == 0) {
            return 'Menunggu Persetujuan';
        } else {
            return '-';
        }
    }

    public function scopeVerifikasiPpk($val)
    {
        $val->whereHas('surat_perjalanan_dinas', function ($q) {
            $q->where('verifikasi_ppk', 1);
        });
    }
    public function notEmpty()
    {
        if ($this->tempat_berangkat && $this->tempat_tujuan && $this->lama_perjalanan && $this->tanggal_berangkat && $this->tanggal_harus_kembali && $this->tingkat_biaya && $this->maksud_perjalanan_dinas && $this->alat_angkut && $this->pembebasan_anggaran && $this->instansi && $this->mata_anggaran_kegiatan) {
            return true;
        } else {
            return false;
        }
    }
}
