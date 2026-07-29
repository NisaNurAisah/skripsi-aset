<?php

namespace App\Http\Controllers;

use App\Models\DataAset;
use App\Models\LaporanInventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    protected function getFilteredData(Request $request)
    {
        $query = DataAset::with(['lokasi']);

        if ($request->kondisi_aset) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }
        if ($request->jenis_aset) {
            $query->where('jenis_aset', $request->jenis_aset);
        }
        if ($request->periode) {
            $query->whereYear('tahun_perolehan', $request->periode);
        }

        return $query->get();
    }

    public function index(Request $request)
    {
        $dataAset = $this->getFilteredData($request);

        $tahunTersedia = DataAset::selectRaw('YEAR(tahun_perolehan) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        $summary = [
            'total' => $dataAset->count(),
            'baik' => $dataAset->where('kondisi_aset', 'Baik')->count(),
            'rusak_ringan' => $dataAset->where('kondisi_aset', 'Rusak Ringan')->count(),
            'rusak_berat' => $dataAset->where('kondisi_aset', 'Rusak Berat')->count(),
        ];

        return view('laporan.index', compact('dataAset', 'tahunTersedia', 'summary'));
    }

    public function cetak(Request $request)
    {
        LaporanInventaris::create([
            'id_pengguna' => session('id_pengguna'),
            'periode' => $request->periode ?? now()->format('Y'),
            'jenis_aset' => $request->jenis_aset ?? 'Semua',
            'tanggal_cetak' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dicatat.');
    }

    public function downloadPdf(Request $request)
    {
        $dataAset = $this->getFilteredData($request);

        $summary = [
            'total' => $dataAset->count(),
            'baik' => $dataAset->where('kondisi_aset', 'Baik')->count(),
            'rusak_ringan' => $dataAset->where('kondisi_aset', 'Rusak Ringan')->count(),
            'rusak_berat' => $dataAset->where('kondisi_aset', 'Rusak Berat')->count(),
        ];

        $periode = $request->periode ?? 'Semua Periode';

        $pdf = Pdf::loadView('laporan.pdf', compact('dataAset', 'summary', 'periode'));
        return $pdf->download('Laporan-Inventaris-' . now()->format('Ymd') . '.pdf');
    }
}