<?php

namespace App\Models;

use Dotenv\Util\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerjalananDinas extends Model
{
    use HasFactory;
    protected $table = 'surat_perjalanan_dinas';
    protected $fillable = [
        'verifikasi_wadir2',
        'verifikasi_ppk',
        'acc_ppk',
        'status',
        'surat_id'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         if (!$model->uuid) {
    //             $model->uuid = Str::uuid();
    //         }
    //     });
    // }
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    public function spd_pelaksana_dinas()
    {
        return $this->hasOne(SPDPelaksana::class, 'surat_perjalanan_dinas_id', 'id');
    }
    public function spd_supir()
    {
        return $this->hasOne(SPDSupir::class, 'surat_perjalanan_dinas_id', 'id');
    }
    // public function details()
    // {
    //     return $this->hasMany(SuratPerjalananDinasDetail::class, 'surat_perjalanan_dinas_id', 'id');
    // }
    // public function detail()
    // {
    //     return $this->hasOne(SuratPerjalananDinasDetail::class, 'surat_perjalanan_dinas_id', 'id');
    // }

    public function tujuan_disposisi()
    {
        return $this->belongsTo(Karyawan::class, 'disposisi_karyawan_id', 'id');
    }

    public function disposisi()
    {
        return $this->hasOne(Disposisi::class, 'surat_perjalanan_dinas_id', 'id')->latest();
    }
    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_perjalanan_dinas_id', 'id')->latest();
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
        $val->whereNotNull('status');
    }

    public function scopeAcc($val)
    {
        $val->where('validasi_pemberangkatan', 1);
    }

    public function scopeGetByKaryawan($val)
    {
        $val->whereHas('disposisi', function ($q) {
            $q->where('tujuan_karyawan_id', auth()->user()->karyawan->id)->orWhere('pembuat_karyawan_id', auth()->user()->karyawan->id);;
        });
    }

    public function verifikasi_wadir2()
    {
        if ($this->verifikasi_wadir2 == 0) {
            return 'Belum Diverifikasi';
        } elseif ($this->verifikasi_wadir2 == 1) {
            return 'Sudah Diverifikasi';
        }
    }

    public function cekVerifikasiSemuaSpj()
    {
        $cek = $this->whereHas('details', function ($q) {
            $q->whereHas('spj', function ($w) {
                $w->where('status', 0);
            });
        })->count();
        // dd($cek);
        if ($cek > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function statusAccPpk()
    {
        if ($this->acc_ppk == 0) {
            return 'Belum Dicek';
        } elseif ($this->acc_ppk == 1) {
            return 'Diterima';
        } else {
            return 'Ditolak';
        }
    }

    public function statusSpd()
    {
        if ($this->verifikasi_ppk == 0) {
            return 'Belum Diverifikasi';
        } else {
            return 'Sudah Diverifikasi PPK';
        }
    }

    public function scopeVerifikasiWadir2($val)
    {
        $val->where('verifikasi_wadir2', 1);
    }


    public function scopeAccPpk($val)
    {
        $val->where('acc_ppk', 1);
    }
    public function scopeVerifikasiWadir2Ppk($val)
    {
        $val->where('verifikasi_wadir2', 1)->where('acc_ppk', 1);
    }

    public function scopeStatusSpdDetail($val)
    {
        $val->whereHas('details');
    }

    // public function statusUangMuka()
    // {
    //     if ($this->uang_muka) {
    //         return 'Sudah Didistribusikan';
    //     } else {
    //         return 'Belum Didistribusikan';
    //     }
    // }

    public function uang_muka()
    {
        return $this->hasOne(UangMuka::class, 'surat_perjalanan_dinas_id', 'id');
    }

    public function scopeVerifikasiPpk($val)
    {
        $val->where('verifikasi_ppk', 1);
    }
}
