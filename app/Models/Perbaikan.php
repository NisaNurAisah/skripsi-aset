<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';
    protected $primaryKey = 'id_perbaikan';
    protected $guarded = [];

    public function aset()
{
    return $this->belongsTo(DataAset::class, 'id_aset', 'id_aset');
}
}
