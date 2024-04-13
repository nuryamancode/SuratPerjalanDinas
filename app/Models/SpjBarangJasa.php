<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpjBarangJasa extends Model
{
    use HasFactory;
    protected $table = 'spj_barang_jasa';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(SpjBarangJasaDetail::class, 'spj_barang_jasa_id', 'id');
    }
    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }
}
