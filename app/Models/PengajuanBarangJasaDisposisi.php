<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaDisposisi extends Model
{
    use HasFactory;
    protected $table = 'pbj_disposisi';
    protected $fillable = [
        'pbj_id',
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


    public function pengajuan_barang_jasa()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pbj_id', 'id');
    }
    public function teruskan1()
    {
        return $this->belongsTo(Karyawan::class, 'teruskan_ke_1', 'id');
    }
    public function teruskan2()
    {
        return $this->belongsTo(Karyawan::class, 'teruskan_ke_2', 'id');
    }
    public function pembuat1()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_disposisi_1', 'id');
    }
    public function pembuat2()
    {
        return $this->belongsTo(Karyawan::class, 'pembuat_disposisi_2', 'id');
    }
    public function pbj()
    {
        return $this->hasOne(PengajuanBarangJasa::class, 'id')->latest();
    }

}
