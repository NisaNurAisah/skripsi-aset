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
    DB::table('lokasi')->insert([
        ['nama_lokasi' => 'Ruang Kepala Desa', 'keterangan' => null],
        ['nama_lokasi' => 'Ruang Sekretariat', 'keterangan' => null],
        ['nama_lokasi' => 'Ruang Pelayanan', 'keterangan' => null],
        ['nama_lokasi' => 'Gudang', 'keterangan' => null],
    ]);
}
}
