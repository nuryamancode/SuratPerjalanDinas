<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjPengusul extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_pengusul';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(SuratNonPbj::class, 'surat_non_pbj_id', 'id');
    }
}
