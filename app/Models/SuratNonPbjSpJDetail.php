<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratNonPbjSpJDetail extends Model
{
    use HasFactory;
    protected $table = 'surat_non_pbj_spj_detail';
    protected $guarded = ['id'];

    public function surat_non_pbj_spj()
    {
        return $this->belongsTo(SuratNonPbjSpj::class);
    }

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }
}
