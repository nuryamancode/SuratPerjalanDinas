<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranPBJ extends Model
{
    use HasFactory;
    protected $table = 'lampiran_pbj';
    protected $guarded = ['id'];
    public function getFile()
    {
        return asset('storage/' . $this->file);
    }

}
