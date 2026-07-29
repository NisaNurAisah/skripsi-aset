<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAset extends Model
{
    protected $table = 'kategori_aset';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

    public function dataAset()
{
    return $this->hasMany(DataAset::class, 'id_kategori', 'id_kategori');
}
}
