<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNonPbjSpj extends Model
{
    use HasFactory;
    protected $table = 'form_non_pbj_spj';
    protected $guarded = ['id'];

    public function formNonPbj()
    {
        return $this->belongsTo(FormNonPbj::class, 'form_non_pbj_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(FormNonPbjSpjDetaili::class, 'form_non_pbj_spj_id', 'id');
    }

    public function acc_ppk()
    {
        if ($this->acc_ppk == 0) {
            return '<span class="badge badge-warning">Menunggu Persetujuan</span>';
        } elseif ($this->acc_ppk == 1) {
            return '<span class="badge badge-success">Disetujui</span>';
        } else {
            return '<span class="badge badge-danger">Ditolak</span>';
        }
    }
}
