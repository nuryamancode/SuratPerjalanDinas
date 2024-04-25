<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNonPbjUangMuka extends Model
{
    use HasFactory;

    protected $table = 'form_non_pbj_uang_muka';
    protected $guarded = ['id'];

    public function form_non_pbj()
    {
        return $this->belongsTo(FormNonPbj::class, 'form_non_pbj_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
