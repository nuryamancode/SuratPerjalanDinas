<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
    public function statusAkun()
    {
        if ($this->user) {
            return 'Ya';
        } else {
            return 'Tidak';
        }
    }

    public function tte()
    {
        return asset('storage/' . $this->tte_file);
    }
}
