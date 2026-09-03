<?php

namespace App\Http\Controllers;

use App\Models\DataAset;
use App\Models\AsetDesa;
use App\Models\KlasifikasiKondisiAset;

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

        // Aktivitas terbaru dari hasil klasifikasi
       $aktivitasTerbaru = KlasifikasiKondisiAset::orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        // Ringkasan Aset Desa
        $totalAsetDesa = AsetDesa::count();
        $totalNilaiAsetDesa = AsetDesa::sum('nilai_perolehan');
        $asetDesaPerJenis = AsetDesa::selectRaw('jenis_aset, COUNT(*) as jumlah')
            ->groupBy('jenis_aset')
            ->orderBy('jumlah', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalAset', 'kondisiBaik', 'rusakRingan', 'rusakBerat',
            'aktivitasTerbaru',
            'totalAsetDesa', 'totalNilaiAsetDesa', 'asetDesaPerJenis'
        ));
    }
}