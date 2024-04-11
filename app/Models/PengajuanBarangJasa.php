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

    public function scopeAccKaryawan($val)
    {
        $val->where('acc_karyawan', 1);
    }

    public function pelaksana()
    {
        return $this->hasMany(PengajuanBarangJasaPelaksana::class);
    }

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

    public function statusAccPengusul()
    {
        if ($this->acc_pengusul == 0) {
            return 'Belum Di Cek';
        } elseif ($this->acc_pengusul == 1) {
            return 'Disetujui';
        } else {
            return 'Ditolak';
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
}
