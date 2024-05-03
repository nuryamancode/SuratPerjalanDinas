<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjDisposisi extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_disposisi';
    protected $guarded = ['id'];

    public function surat_non_pbj()
    {
        return $this->belongsTo(SuratNonPbj::class, 'surat_non_pbj_id', 'id');
    }


    public function pembuat()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_karyawan_id', 'id');
    }

    public function tujuan()
    {
        return $this->belongsTo(Karyawan::class, 'tujuan_karyawan_id', 'id');
    }
}
