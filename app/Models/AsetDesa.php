<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetDesa extends Model
{
    protected $table = 'aset_desa';
    protected $primaryKey = 'id_aset_desa';
    protected $guarded = [];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
}