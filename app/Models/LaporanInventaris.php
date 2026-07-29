<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanInventaris extends Model
{
    protected $table = 'laporan_inventaris';
    protected $primaryKey = 'id_laporan';
    protected $guarded = [];
}
