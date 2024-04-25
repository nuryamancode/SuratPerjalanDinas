<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNonPbj extends Model
{
    use HasFactory;
    protected $table = 'form_non_pbj';
    protected $guarded = ['id'];

    public function getFile()
    {
        return asset('storage/' . $this->file);
    }
    public function uang_muka1()
    {
        return $this->hasOne(FormNonPbjUangMuka::class, 'form_non_pbj_id', 'id');
    }
    public function disposisi()
    {
        return $this->hasOne(FormNonPbjDisposisi::class, 'form_non_pbj_id', 'id')->latest();
    }
    public function disposisis()
    {
        return $this->hasMany(FormNonPbjDisposisi::class, 'form_non_pbj_id', 'id');
    }

    public function spj()
    {
        return $this->hasOne(FormNonPbjSpj::class, 'form_non_pbj_id', 'id');
    }
}
