<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpjBarangJasa extends Model
{
    use HasFactory;
    protected $table = 'spj_barang_jasa';
    protected $guarded = ['id'];
}
