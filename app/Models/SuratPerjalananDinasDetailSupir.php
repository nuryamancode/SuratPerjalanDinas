<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerjalananDinasDetailSupir extends Model
{
    use HasFactory;
    protected $table = 'spd_detail_supir';
    protected $guarded = [];
    public function spd_detail()
    {
        return $this->belongsTo(SuratPerjalananDinasDetail::class, 'spd_detail_id', 'id');
    }
}
