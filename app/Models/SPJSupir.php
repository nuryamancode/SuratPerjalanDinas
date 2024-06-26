<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPJSupir extends Model
{
    use HasFactory;
    protected $table = 'spj_supir';
    protected $guarded = ['id'];


    public function spd()
    {
        return $this->belongsTo(SPDSupir::class, 'spd_id', 'id');
    }
    public function supir()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_spj', 'id');
    }
    public function details()
    {
        return $this->hasMany(SPJSupirDetail::class, 'spj_id', 'id');
    }
    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }
    public function status()
    {
        if ($this->acc_ppk == 0) {
            return '<span class="badge badge-warning">Menunggu Persetujuan</span>';
        } elseif ($this->acc_ppk == 1) {
            return '<span class="badge badge-success">Disetujui</span>';
        } else {
            return '<span class="badge badge-danger">Ditolak</span>';
        }
    }

    public function scopeGetByKaryawan($val)
    {
        $val->where('karyawan_id', auth()->user()->karyawan->id);
    }
}
