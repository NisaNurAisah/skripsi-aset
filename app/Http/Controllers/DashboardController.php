<?php

namespace App\Http\Controllers;

use App\Models\DataAset;
use App\Models\KlasifikasiKondisiAset;
use App\Models\KategoriAset;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('id_pengguna')) {
            return redirect('/login');
        }

        $totalAset = DataAset::count();
        $kondisiBaik = DataAset::where('kondisi_aset', 'Baik')->count();
        $rusakRingan = DataAset::where('kondisi_aset', 'Rusak Ringan')->count();
        $rusakBerat = DataAset::where('kondisi_aset', 'Rusak Berat')->count();

        // Distribusi kategori (buat pie chart)
        $kategoriData = KategoriAset::withCount('dataAset')->get();

        // Aktivitas terbaru dari hasil klasifikasi
       $aktivitasTerbaru = KlasifikasiKondisiAset::orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('dashboard', compact(
            'totalAset', 'kondisiBaik', 'rusakRingan', 'rusakBerat',
            'kategoriData', 'aktivitasTerbaru'
        ));
    }
}