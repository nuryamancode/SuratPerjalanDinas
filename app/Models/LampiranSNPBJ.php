<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranSNPBJ extends Model
{
    use HasFactory;
    protected $table = 'lampiran_surat_non_pbj';
    protected $guarded = ['id'];
    public function getFile()
    {
        return asset('storage/' . $this->file);
    }
}
