<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerusDisposisiNSPBJ extends Model
{
    use HasFactory;
    protected $table = 'diteruskan_suratnpbj';
    protected $fillable = [
        'pbj_disposisi_id',
        'penerus_disposisi_id',
    ];
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'penerus_disposisi_id','id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBarangJasaDisposisi::class, 'pbj_disposisi_id', 'id');
    }
}
