<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(DisposisiDetail::class);
    }
}
