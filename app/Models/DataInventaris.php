<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataInventaris extends Model
{
    protected $table = 'data_inventaris';
    protected $primaryKey = 'id_inventaris';
    protected $guarded = [];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }

    public function perbaikan()
    {
        return $this->hasMany(Perbaikan::class, 'id_inventaris', 'id_inventaris');
    }
}