<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $guarded = ['id'];

    public function surat_perjalanan_dinas()
    {
        return $this->hasOne(SuratPerjalananDinas::class);
    }

    public function getFile()
    {
        return asset('storage/' . $this->file);
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class);
    }

    public function pelaksana()
    {
        return $this->hasMany(Pelaksana::class);
    }

    public function scopeIsNotUsed()
    {
        return $this->whereDoesntHave('surat_perjalanan_dinas');
    }

    public function status()
    {
        if ($this->surat_perjalanan_dinas->disposisi) {
            return 'Sudah Didisposisikan';
        } else {
            return 'Belum Didisposisikan';
        }
    }
}
