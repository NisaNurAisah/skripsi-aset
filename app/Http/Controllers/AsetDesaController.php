<?php

namespace App\Http\Controllers;

use App\Models\AsetDesa;
use App\Models\Lokasi;
use Illuminate\Http\Request;

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
        $jenisAsetList = ['Tanah', 'Jalan dan Irigasi', 'Bangunan'];

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
}