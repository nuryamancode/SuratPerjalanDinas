<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPJSupirDetail extends Model
{
    use HasFactory;
    protected $table = 'spj_supir_detail';
    protected $guarded = ['id'];


    public function spj()
    {
        return $this->belongsTo(SPJSupir::class, 'spj_id', 'id');
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
