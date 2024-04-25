<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNonPbjSpjDetaili extends Model
{
    use HasFactory;
    protected $table = 'form_non_pbj_spj_detail';
    protected $guarded = ['id'];

    public function formNonPbjSpj()
    {
        return $this->belongsTo(FormNonPbjSpj::class, 'form_non_pbj_spj_id', 'id');
    }

    public function downloadFile()
    {
        return asset('storage/' . $this->file);
    }
}
