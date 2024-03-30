<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangMuka extends Model
{
    use HasFactory;
    protected $table = 'uang_muka';
    protected $guarded = ['id'];

    public function spd()
    {
        return $this->belongsTo(SuratPerjalananDinas::class, 'surat_perjalanan_dinas_id', 'id');
    }
}
