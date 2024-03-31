<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPertanggungJawabanDetail extends Model
{
    use HasFactory;
    protected $table = 'surat_pertanggung_jawaban_detail';
    protected $guarded = ['id'];

    public function spj()
    {
        return $this->belongsTo(SuratPertanggungJawaban::class, 'spj_id', 'id');
    }

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }

    public function scopeGetByKaryawan($val)
    {
        $val->where('karyawan_id', auth()->user()->karyawan->id);
    }
}
