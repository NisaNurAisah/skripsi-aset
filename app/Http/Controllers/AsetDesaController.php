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

        // Kategori jenis aset tetap desa (fixed, urut sesuai standar)
        $jenisAsetList = ['Tanah', 'Jalan dan Irigasi', 'Bangunan', 'Sawah'];

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
            'id_lokasi' => 'required',
            'tahun_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'jumlah_aset' => 'required|numeric|min:1',
            'gambar_aset' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar_aset');

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

    // Kategori cara perolehan aset desa (fixed)
    public static function caraPerolehanList()
    {
        return ['Pembelian', 'Hibah', 'Bantuan Pemerintah', 'Swadaya Masyarakat', 'Lainnya'];
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
}