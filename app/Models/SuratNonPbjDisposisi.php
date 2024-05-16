<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjDisposisi extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_disposisi';
    protected $fillable = [
        'snpbj_id',
        'tipe_disposisi_1',
        'tipe_disposisi_2',
        'catatan_disposisi_1',
        'catatan_disposisi_2',
        'pembuat_disposisi_1',
        'pembuat_disposisi_2',
        'teruskan_ke_1',
        'teruskan_ke_2',
        'pelaksana_belanja',
    ];
    protected $guarded = ['id'];


    public function surat_non_pbj()
    {
        return $this->belongsTo(SuratNonPbj::class, 'snpbj_id', 'id');
    }
    public function teruskan1()
    {
        return $this->belongsTo(Karyawan::class, 'teruskan_ke_1', 'id');
    }
    public function teruskan2()
    {
        return $this->belongsTo(Karyawan::class, 'teruskan_ke_2', 'id');
    }
    public function teruskan3()
    {
        return $this->belongsTo(Karyawan::class, 'teruskan_ke_3', 'id');
    }
    public function pembuat1()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_disposisi_1', 'id');
    }
    public function pembuat2()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_disposisi_2', 'id');
    }
    public function pembuat3()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_disposisi_3', 'id');
    }
}
