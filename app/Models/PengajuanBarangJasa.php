<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasa extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_barang_jasa';
    protected $guarded = ['id'];

    public function scopePbj($val)
    {
        $val->where('jenis', 'pbj');
    }

    public function scopeFormNonPbj($val)
    {
        $val->where('jenis', 'formulir non pbj');
    }
    public function scopeAccAll($val)
    {
        $val->where('acc_wadir2', 1)->where('acc_ppk', 1);
    }

    public function scopeVerifikasiPengusul($val)
    {
        $val->where('verifikasi_pengusul', 1);
    }


    public function scopeVerifikasiWadir1($val)
    {
        $val->where('verifikasi_wadir1', 1);
    }
    public function scopeAccWadir2($val)
    {
        $val->where('acc_wadir2', 1);
    }


    public function scopeAccPpk($val)
    {
        $val->where('acc_ppk', 1);
    }

    public function scopeVerifikasiWadirKabag($val)
    {
        $val->where('verifikasi_wadir1', 1)->orWhere('verifikasi_kabag', 1);
    }

    public function scopeVerifikasiUangMuka($val)
    {
        $val->whereHas('uang_muka');
    }

    public function pelaksana()
    {
        return $this->hasMany(PengajuanBarangJasaPelaksana::class);
    }

    public function pengusul()
    {
        return $this->hasMany(PengajuanBarangJasaPengusul::class);
    }

    // public function statusSpjFormNonPbj()
    // {
    //     return $this->pelaksana()->where('karyawan_id', auth()->user()->karyawan->id)->spjFormNonPbj->exists();
    // }

    public function status()
    {
        if ($this->disposisi) {
            return 'Sudah Didisposisikan';
        } else {
            return 'Belum Didisposisikan';
        }
    }


    public function statusVerifikasi()
    {
        if ($this->acc_karyawan == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_karyawan == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak';
        }
    }

    public function statusAccWadir2()
    {
        if ($this->acc_wadir2 == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_wadir2 == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak';
        }
    }

    public function statusAccPpk()
    {
        if ($this->acc_ppk == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_ppk == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak';
        }
    }

    public function statusVerifikasiPengusul()
    {
        if ($this->verifikasi_pengusul == 1) {
            return 'Telah Diverifikasi';
        } else {
            return 'Belum Diverifikasi';
        }
    }

    public function statusVerifikasiWadir1()
    {
        if ($this->verifikasi_wadir1 == 1) {
            return 'Telah Diverifikasi';
        } else {
            return 'Belum Diverifikasi';
        }
    }

    public function statusVerifikasiKabag()
    {
        if ($this->verifikasi_kabag == 1) {
            return 'Telah Diverifikasi';
        } else {
            return 'Belum Diverifikasi';
        }
    }

    public function details()
    {
        return $this->hasMany(PengajuanBarangJasaDetail::class);
    }

    public function disposisi()
    {
        return $this->hasOne(PengajuanBarangJasaDisposisi::class, 'pengajuan_barang_jasa_id', 'id')->latest();
    }

    public function disposisis()
    {
        return $this->hasMany(PengajuanBarangJasaDisposisi::class, 'pengajuan_barang_jasa_id', 'id');
    }

    public function scopeFormNonPbjAccAll($val)
    {
        $val->where([
            'acc_pengusul' => 1,
            'acc_ppk' => 1
        ]);
    }

    public function formNonPbjAccAll()
    {
        if ($this->acc_pengusul == 1 && $this->acc_ppk == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function uang_muka()
    {
        return $this->hasOne(UangMukaBarangjasa::class, 'pengajuan_barang_jasa_id', 'id');
    }

    public function statusUangMuka()
    {
        if ($this->uang_muka) {
            return 'Sudah Didistribusikan';
        } else {
            return 'Belum Didistribusikan';
        }
    }

    public function proses()
    {
        return $this->hasMany(ProsesPbj::class, 'pengajuan_barang_jasa_id', 'id')->latest();
    }
}
