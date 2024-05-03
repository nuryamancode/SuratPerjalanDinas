<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjDetail extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_detail';
    protected $guarded = ['id'];

    public function surat_non_pbj()
    {
        return $this->belongsTo(SuratNonPbj::class);
    }
}
