<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpjBarangJasaDetail extends Model
{
    use HasFactory;
    protected $table = 'spj_barang_jasa_detail';
    protected $guarded = ['id'];

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }

    public function spjFormNonPbj()
    {
        return $this->belongsTo(SpjBarangJasa::class, 'spj_barang_jasa_id', 'id');
    }
}
