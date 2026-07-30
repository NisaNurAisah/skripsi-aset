<?php

namespace App\Http\Controllers;

use App\Models\DataAset;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DataAsetController extends Controller
{
    public function index(Request $request)
{
    $query = DataAset::with('lokasi');

    if ($request->search) {
        $query->where('nama_aset', 'like', '%' . $request->search . '%');
    }

    if ($request->kondisi_aset) {
        $query->where('kondisi_aset', $request->kondisi_aset);
    }

    $dataAset = $query->get();
    return view('aset.index', compact('dataAset'));
}

    public function create()
    {
        $lokasi = Lokasi::all();
        return view('aset.create', compact('lokasi'));
    }

  public function store(Request $request)
{
    $request->validate([
        'nama_aset' => 'required',
        'jenis_aset' => 'required',
        'id_lokasi' => 'required',
        'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
        'nilai_perolehan' => 'required|numeric',
        'gambar_aset' => 'nullable|image|max:2048',
    ]);

    $data = $request->except('gambar_aset');
    $data['tahun_perolehan'] = $request->tahun_perolehan . '-01-01';

    if ($request->hasFile('gambar_aset')) {
        $data['gambar_aset'] = $request->file('gambar_aset')->store('aset', 'public');
    }

    DataAset::create($data);

    return redirect('/data-aset')->with('success', 'Data inventaris berhasil ditambahkan');
}

    public function edit($id_aset)
    {
        $aset = DataAset::findOrFail($id_aset);
        $lokasi = Lokasi::all();
        return view('aset.edit', compact('aset', 'lokasi'));
    }

  public function update(Request $request, $id_aset)
{
    $aset = DataAset::findOrFail($id_aset);

    $request->validate([
        'nama_aset' => 'required',
        'jenis_aset' => 'required',
        'id_lokasi' => 'required',
        'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
        'nilai_perolehan' => 'required|numeric',
        'gambar_aset' => 'nullable|image|max:2048',
    ]);

    $data = $request->except('gambar_aset');
    $data['tahun_perolehan'] = $request->tahun_perolehan . '-01-01';

    if ($request->hasFile('gambar_aset')) {
        $data['gambar_aset'] = $request->file('gambar_aset')->store('aset', 'public');
    }

    $aset->update($data);
    return redirect('/data-aset')->with('success', 'Data inventaris berhasil diperbarui');
}
    public function destroy($id_aset)
    {
        DataAset::findOrFail($id_aset)->delete();
        return redirect('/data-aset')->with('success', 'Data inventaris berhasil dihapus');
    }

    public function downloadPdf(Request $request)
    {
        $query = DataAset::with('lokasi');

        if ($request->search) {
    $query->where('nama_aset', 'like', '%' . $request->search . '%');
}
        if ($request->kondisi_aset) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }

        $dataAset = $query->get();

        $pdf = Pdf::loadView('aset.pdf', compact('dataAset'));
        return $pdf->download('Data-Inventaris-' . now()->format('Ymd') . '.pdf');
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