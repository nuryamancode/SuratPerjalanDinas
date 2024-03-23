<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiDetail extends Model
{
    use HasFactory;
    protected $table = 'disposisi_detail';
    protected $guarded = ['id'];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
