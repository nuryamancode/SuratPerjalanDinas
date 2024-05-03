<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjUangMuka extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_uang_muka';
    protected $guarded = ['id'];

    public function surat_non_pbj()
    {
        return $this->belongsTo(SuratNonPbj::class);
    }
}
