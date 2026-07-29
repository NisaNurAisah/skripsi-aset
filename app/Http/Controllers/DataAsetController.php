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
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
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
            'kode_aset' => 'required|unique:data_aset,kode_aset',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'id_lokasi' => 'required',
            'tahun_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'gambar_aset' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('gambar_aset');

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
        $data = $request->except('gambar_aset');

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
            $query->where(function($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->kondisi_aset) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }

        $dataAset = $query->get();

        $pdf = Pdf::loadView('aset.pdf', compact('dataAset'));
        return $pdf->download('Data-Inventaris-' . now()->format('Ymd') . '.pdf');
    }
}