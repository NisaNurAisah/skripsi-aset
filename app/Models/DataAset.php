<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAset extends Model
{
    protected $table = 'data_aset';
    protected $primaryKey = 'id_aset';
    protected $guarded = [];

public function lokasi()
{
    return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
}
public function perbaikan()
{
    return $this->hasMany(Perbaikan::class, 'id_aset', 'id_aset');
}
}

