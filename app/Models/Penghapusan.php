<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghapusan extends Model
{
    protected $table = 'penghapusan';
    protected $primaryKey = 'id_penghapusan';
    protected $guarded = [];

    public function aset()
{
    return $this->belongsTo(DataAset::class, 'id_aset', 'id_aset');
}
}
