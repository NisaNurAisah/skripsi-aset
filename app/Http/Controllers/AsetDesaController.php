<?php

namespace App\Http\Controllers;

use App\Models\AsetDesa;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AsetDesaController extends Controller
{
    public function index(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->jenis_aset) {
            $query->where('jenis_aset', $request->jenis_aset);
        }

        $asetDesa = $query->get();

        $jenisAsetList = ['Tanah', 'Jalan dan Irigasi', 'Bangunan', 'Sawah', 'Kendaraan'];

        return view('aset-desa.index', compact('asetDesa', 'jenisAsetList'));
    }

    public function create()
    {
        $lokasi = Lokasi::all();
        return view('aset-desa.create', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:aset_desa,kode_aset',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'cara_perolehan' => 'nullable',
            'tahun_perolehan' => 'required|integer|min:1900|max:' . date('Y'),
            'nilai_perolehan' => 'required|numeric',
            'nup' => 'nullable',
            'ukuran_luas' => 'nullable',
            'tipe' => 'nullable',
            'atas_hak' => 'nullable',
            'merk_type' => 'nullable',
            'nomor_identitas' => 'nullable',
            'kondisi_aset' => 'nullable',
            'gambar_aset' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar_aset');
        $data = $request->except('gambar_aset');
        $data['tahun_perolehan'] = $request->tahun_perolehan . '-01-01';

        if ($request->hasFile('gambar_aset')) {
            $data['gambar_aset'] = $request->file('gambar_aset')->store('aset-desa', 'public');
        }

        AsetDesa::create($data);

        return redirect('/data-aset-desa')->with('success', 'Data aset desa berhasil ditambahkan');
    }

    public function edit($id_aset_desa)
    {
        $aset = AsetDesa::findOrFail($id_aset_desa);
        $lokasi = Lokasi::all();
        return view('aset-desa.edit', compact('aset', 'lokasi'));
    }

    public function update(Request $request, $id_aset_desa)
    {
        $aset = AsetDesa::findOrFail($id_aset_desa);
        $data = $request->except('gambar_aset');

        if ($request->hasFile('gambar_aset')) {
            $data['gambar_aset'] = $request->file('gambar_aset')->store('aset-desa', 'public');
        }

        $aset->update($data);
        return redirect('/data-aset-desa')->with('success', 'Data aset desa berhasil diperbarui');
    }

    public function destroy($id_aset_desa)
    {
        AsetDesa::findOrFail($id_aset_desa)->delete();
        return redirect('/data-aset-desa')->with('success', 'Data aset desa berhasil dihapus');
    }

    public function downloadPdf(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->jenis_aset) {
            $query->where('jenis_aset', $request->jenis_aset);
        }

        $asetDesa = $query->get();
        $judul = $request->jenis_aset ? 'DATA ASET DESA - ' . strtoupper($request->jenis_aset) : 'DATA ASET DESA';

        $pdf = Pdf::loadView('aset-desa.pdf', compact('asetDesa', 'judul'));
        return $pdf->download('Data-Aset-Desa-' . now()->format('Ymd') . '.pdf');
    }

    public static function caraPerolehanList()
    {
        return ['Pembelian', 'Hibah', 'Bantuan Pemerintah', 'Swadaya Masyarakat', 'Dana Desa', 'DBH', 'Banprov', 'Pemekaran', 'Lainnya'];
    }

    public function pengadaan(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->cara_perolehan) {
            $query->where('cara_perolehan', $request->cara_perolehan);
        }

        $asetDesa = $query->orderBy('tahun_perolehan', 'desc')->get();
        $caraPerolehanList = self::caraPerolehanList();

        return view('aset-desa.pengadaan', compact('asetDesa', 'caraPerolehanList'));
    }

    public function downloadPdfPengadaan(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->cara_perolehan) {
            $query->where('cara_perolehan', $request->cara_perolehan);
        }

        $asetDesa = $query->orderBy('tahun_perolehan', 'desc')->get();
        $judul = $request->cara_perolehan ? 'PENGADAAN ASET - ' . strtoupper($request->cara_perolehan) : 'PENGADAAN ASET';

        $pdf = Pdf::loadView('aset-desa.pdf-pengadaan', compact('asetDesa', 'judul'));
        return $pdf->download('Pengadaan-Aset-' . now()->format('Ymd') . '.pdf');
    }

    public function laporan(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->jenis_aset) {
            $query->where('jenis_aset', $request->jenis_aset);
        }
        if ($request->kondisi_aset) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }
        if ($request->periode) {
            $query->whereYear('tahun_perolehan', $request->periode);
        }

        $asetDesa = $query->get();

        $tahunTersedia = AsetDesa::selectRaw('YEAR(tahun_perolehan) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        $summary = [
            'total' => $asetDesa->count(),
            'baik' => $asetDesa->where('kondisi_aset', 'Baik')->count(),
            'rusak_ringan' => $asetDesa->where('kondisi_aset', 'Rusak Ringan')->count(),
            'rusak_berat' => $asetDesa->where('kondisi_aset', 'Rusak Berat')->count(),
        ];

        return view('aset-desa.laporan', compact('asetDesa', 'tahunTersedia', 'summary'));
    }

    public function downloadPdfLaporan(Request $request)
    {
        $query = AsetDesa::with('lokasi');

        if ($request->jenis_aset) {
            $query->where('jenis_aset', $request->jenis_aset);
        }
        if ($request->kondisi_aset) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }
        if ($request->periode) {
            $query->whereYear('tahun_perolehan', $request->periode);
        }

        $asetDesa = $query->get();
        $periode = $request->periode ?? 'Semua Periode';

        $pdf = Pdf::loadView('aset-desa.pdf-laporan', compact('asetDesa', 'periode'));
        return $pdf->download('Laporan-Aset-Desa-' . now()->format('Ymd') . '.pdf');
    }
}