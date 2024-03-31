<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerjalananDinasDetail extends Model
{
    use HasFactory;
    protected $table = 'surat_perjalanan_dinas_detail';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function surat_perjalanan_dinas()
    {
        return $this->belongsTo(SuratPerjalananDinas::class);
    }

    public function supir()
    {
        return $this->hasMany(SuratPerjalananDinasDetailSupir::class, 'spd_detail_id', 'id');
    }

    public function spj()
    {
        return $this->hasOne(SuratPertanggungJawaban::class, 'spd_detail_id', 'id');
    }

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }

    public function scopeGetByKaryawan($val)
    {
        $val->where('karyawan_id', auth()->user()->karyawan->id);
    }
}
