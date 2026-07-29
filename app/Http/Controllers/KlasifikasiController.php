<?php

namespace App\Http\Controllers;

use App\Models\KlasifikasiKondisiAset;
use App\Services\KnnService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KlasifikasiController extends Controller
{
    protected $knnService;

    public function __construct(KnnService $knnService)
    {
        $this->knnService = $knnService;
    }

   public function index()
{
    $riwayat = KlasifikasiKondisiAset::where('created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'desc')
        ->get();
    return view('klasifikasi.index', compact('riwayat'));
}

public function riwayatLengkap(Request $request)
{
    $query = KlasifikasiKondisiAset::query();

    if ($request->periode) {
        $query->whereYear('tanggal_klasifikasi', substr($request->periode, 0, 4))
              ->whereMonth('tanggal_klasifikasi', substr($request->periode, 5, 2));
    }

    $sort = $request->sort ?? 'terbaru';
    if ($sort == 'terlama') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $riwayat = $query->get();

    $periodeTersedia = KlasifikasiKondisiAset::selectRaw("DATE_FORMAT(tanggal_klasifikasi, '%Y-%m') as periode")
        ->distinct()->orderBy('periode', 'desc')->pluck('periode');

    return view('klasifikasi.riwayat-lengkap', compact('riwayat', 'periodeTersedia'));
}

    public function riwayat()
    {
        $riwayat = KlasifikasiKondisiAset::orderBy('created_at', 'desc')->get();
        return view('klasifikasi.riwayat', compact('riwayat'));
    }

    public function klasifikasikan(Request $request)
    {
        $request->validate([
            'nama_aset_uji' => 'required',
            'jenis_aset_uji' => 'required',
            'intensitas_penggunaan_uji' => 'required',
            'tahun_perolehan_uji' => 'required|integer',
        ]);

        $usiaAset = (int) date('Y') - (int) $request->tahun_perolehan_uji;

        $hasil = $this->knnService->klasifikasi(
            $request->jenis_aset_uji,
            $request->intensitas_penggunaan_uji,
            $usiaAset,
            3
        );

        $klasifikasi = KlasifikasiKondisiAset::create([
            'nama_aset_uji' => $request->nama_aset_uji,
            'jenis_aset_uji' => $request->jenis_aset_uji,
            'intensitas_penggunaan_uji' => $request->intensitas_penggunaan_uji,
            'usia_aset_uji' => $usiaAset,
            'nilai_k' => 3,
            'hasil_klasifikasi' => $hasil['hasil_klasifikasi'],
            'tanggal_klasifikasi' => now(),
        ]);

        return view('klasifikasi.hasil', [
            'hasil' => $hasil,
            'klasifikasi' => $klasifikasi,
        ]);
    }

    public function downloadPdf($id_klasifikasi)
    {
        $klasifikasi = KlasifikasiKondisiAset::findOrFail($id_klasifikasi);

        $hasil = $this->knnService->klasifikasi(
            $klasifikasi->jenis_aset_uji,
            $klasifikasi->intensitas_penggunaan_uji,
            $klasifikasi->usia_aset_uji,
            $klasifikasi->nilai_k
        );

        $pdf = Pdf::loadView('klasifikasi.pdf', compact('klasifikasi', 'hasil'));
        return $pdf->download('Hasil-Klasifikasi-' . str_replace(' ', '-', $klasifikasi->nama_aset_uji) . '.pdf');
    }
}