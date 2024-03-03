<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $guarded = ['id'];

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class);
    }

    public function pelaksana()
    {
        return $this->hasMany(Pelaksana::class);
    }
}
