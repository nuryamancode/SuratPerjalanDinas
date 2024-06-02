<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    protected $guarded = ['id'];

    public function tujuan()
    {
        return $this->belongsTo(Karyawan::class, 'tujuan_karyawan_id_1', 'id');
    }
    public function tujuan2()
    {
        return $this->belongsTo(Karyawan::class, 'tujuan_karyawan_id_2', 'id');
    }

    public function pembuat()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_karyawan_id_1', 'id');
    }
    public function pembuat2()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_karyawan_id_2', 'id');
    }

    public function spd()
    {
        return $this->belongsTo(SuratPerjalananDinas::class, 'surat_perjalanan_dinas_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(DisposisiDetail::class);
    }
}
