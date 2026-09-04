<?php

namespace App\Http\Controllers;

use App\Models\DataInventaris;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DataInventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = DataInventaris::with('lokasi');

        if ($request->search) {
            $query->where('nama_inventaris', 'like', '%' . $request->search . '%');
        }
        if ($request->kondisi_inventaris) {
            $query->where('kondisi_inventaris', $request->kondisi_inventaris);
        }

        $dataInventaris = $query->get();
        return view('data-inventaris.index', compact('dataInventaris'));
    }

    public function create()
    {
        $lokasi = Lokasi::all();
        return view('data-inventaris.create', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_inventaris' => 'required',
            'jenis_inventaris' => 'required',
            'id_lokasi' => 'required',
            'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
            'nilai_perolehan' => 'required|numeric',
            'gambar_inventaris' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar_inventaris');
        $data['tahun_perolehan'] = $request->tahun_perolehan . '-01-01';

        if ($request->hasFile('gambar_inventaris')) {
            $data['gambar_inventaris'] = $request->file('gambar_inventaris')->store('inventaris', 'public');
        }

        DataInventaris::create($data);

        return redirect('/data-inventaris')->with('success', 'Data inventaris berhasil ditambahkan');
    }

    public function edit($id_inventaris)
    {
        $inventaris = DataInventaris::findOrFail($id_inventaris);
        $lokasi = Lokasi::all();
        return view('data-inventaris.edit', compact('inventaris', 'lokasi'));
    }

    public function update(Request $request, $id_inventaris)
    {
        $inventaris = DataInventaris::findOrFail($id_inventaris);

        $request->validate([
            'nama_inventaris' => 'required',
            'jenis_inventaris' => 'required',
            'id_lokasi' => 'required',
            'tahun_perolehan' => 'required|integer|min:2000|max:' . date('Y'),
            'nilai_perolehan' => 'required|numeric',
            'gambar_inventaris' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar_inventaris');
        $data['tahun_perolehan'] = $request->tahun_perolehan . '-01-01';

        if ($request->hasFile('gambar_inventaris')) {
            $data['gambar_inventaris'] = $request->file('gambar_inventaris')->store('inventaris', 'public');
        }

        $inventaris->update($data);
        return redirect('/data-inventaris')->with('success', 'Data inventaris berhasil diperbarui');
    }

    public function destroy($id_inventaris)
    {
        DataInventaris::findOrFail($id_inventaris)->delete();
        return redirect('/data-inventaris')->with('success', 'Data inventaris berhasil dihapus');
    }

    public function downloadPdf(Request $request)
    {
        $query = DataInventaris::with('lokasi');

        if ($request->search) {
            $query->where('nama_inventaris', 'like', '%' . $request->search . '%');
        }
        if ($request->kondisi_inventaris) {
            $query->where('kondisi_inventaris', $request->kondisi_inventaris);
        }

        $dataInventaris = $query->get();

        $pdf = Pdf::loadView('data-inventaris.pdf', compact('dataInventaris'));
        return $pdf->download('Data-Inventaris-' . now()->format('Ymd') . '.pdf');
    }
}