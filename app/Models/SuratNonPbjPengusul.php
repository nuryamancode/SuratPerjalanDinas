<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjPengusul extends Model
{
    use HasFactory;
    protected $table = 'diteruskan_suratnpbj';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class,'penerus_disposisi_id', 'id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(SuratNonPbj::class, 'surat_non_pbj_id', 'id');
    }
    public function penerus(){
        return $this->hasMany(Karyawan::class,'penerus_disposisi_id', 'id');
    }
}
