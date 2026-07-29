<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataLatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('data_latih')->insert([
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 9, 'label_kondisi' => 'Rusak Ringan'],   // Komputer LG
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 2, 'label_kondisi' => 'Baik'],           // Printer Epson L3110
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 9, 'label_kondisi' => 'Rusak Ringan'],   // Laptop Acer
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 2, 'label_kondisi' => 'Baik'],           // Laptop Asus
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Sedang', 'usia_aset' => 11, 'label_kondisi' => 'Rusak Berat'],   // Dispenser Miyako
             ['jenis_aset' => 'Furnitur', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 1, 'label_kondisi' => 'Rusak Ringan'],     // Kursi Kantor
             ['jenis_aset' => 'Furnitur', 'intensitas_penggunaan' => 'Tinggi', 'usia_aset' => 8, 'label_kondisi' => 'Rusak Ringan'],     // Meja Kantor
             ['jenis_aset' => 'Furnitur', 'intensitas_penggunaan' => 'Rendah', 'usia_aset' => 8, 'label_kondisi' => 'Rusak Berat'],      // Lemari Arsip
             ['jenis_aset' => 'Perlengkapan Kantor', 'intensitas_penggunaan' => 'Rendah', 'usia_aset' => 10, 'label_kondisi' => 'Rusak Berat'], // APAR
             ['jenis_aset' => 'Elektronik', 'intensitas_penggunaan' => 'Sedang', 'usia_aset' => 6, 'label_kondisi' => 'Baik'],           // Televisi Polytron
      ]);
    }
}
