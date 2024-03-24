<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    protected $guarded = ['id'];

    public function tujuan()
    {
        return $this->belongsTo(Karyawan::class, 'tujuan_karyawan_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(DisposisiDetail::class);
    }
}
