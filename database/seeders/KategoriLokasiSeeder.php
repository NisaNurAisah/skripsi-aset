<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('kategori_aset')->insert([
        ['jenis_kategori' => 'Elektronik', 'kode_kategori' => 'ELK'],
        ['jenis_kategori' => 'Furnitur', 'kode_kategori' => 'FUR'],
        ['jenis_kategori' => 'Peralatan Kantor', 'kode_kategori' => 'PRK'],
        ['jenis_kategori' => 'Perlengkapan Kantor', 'kode_kategori' => 'PLK'],
    ]);

    DB::table('lokasi')->insert([
        ['nama_lokasi' => 'Ruang Kepala Desa', 'keterangan' => null],
        ['nama_lokasi' => 'Ruang Sekretariat', 'keterangan' => null],
        ['nama_lokasi' => 'Ruang Pelayanan', 'keterangan' => null],
        ['nama_lokasi' => 'Gudang', 'keterangan' => null],
    ]);
}
}
