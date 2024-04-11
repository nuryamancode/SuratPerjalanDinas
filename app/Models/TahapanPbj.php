<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPbj extends Model
{
    use HasFactory;
    protected $table = 'tahapan_pbj';
    protected $guarded = ['id'];
}
