<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangJasaPengusul extends Model
{
    use HasFactory;
    protected $table = 'pbj_pengusul';
    protected $fillable = [
        'pbj_id',
        'pengusul_id',
    ];
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'pengusul_id','id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBarangJasa::class, 'pbj_id', 'id');
    }
}
