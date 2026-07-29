<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use Illuminate\Http\Request;
use App\Models\DataAset;

class DataLatihController extends Controller
{
    public function index(Request $request)
    {
        $query = DataLatih::query();

        if ($request->search) {
            $query->where('jenis_aset', 'like', '%' . $request->search . '%');
        }

    $dataLatih = $query->get();
    return view('data-latih.index', compact('dataLatih'));
}

    public function create()
{
    $dataAset = DataAset::whereHas('kategori', function($q) {
        $q->where('jenis_kategori', 'Bergerak');
    })->get();

    return view('data-latih.create', compact('dataAset'));
}

   public function store(Request $request)
{
    $data = [];

if ($request->mode == 'aset' && $request->id_aset) {
    $aset = DataAset::whereHas('kategori', function($q) {
        $q->where('jenis_kategori', 'Bergerak');
    })->findOrFail($request->id_aset);

    if (!$aset->kondisi_aset) {
        return back()->withErrors(['id_aset' => 'Aset ini belum memiliki kondisi. Silakan klasifikasikan terlebih dahulu, atau pilih mode Input Manual.'])->withInput();
    }

    $tahunPerolehan = (int) date('Y', strtotime($aset->tahun_perolehan));
    $data = [
        'id_aset' => $aset->id_aset,
        'jenis_aset' => $aset->jenis_aset,
        'intensitas_penggunaan' => $aset->intensitas_penggunaan,
        'usia_aset' => (int) date('Y') - $tahunPerolehan,
        'label_kondisi' => $aset->kondisi_aset,
    ];
    } else {
        $request->validate([
            'jenis_aset' => 'required',
            'intensitas_penggunaan' => 'required',
            'usia_aset' => 'required|numeric',
            'label_kondisi' => 'required',
        ]);
        $data = [
            'id_aset' => null,
            'jenis_aset' => $request->jenis_aset,
            'intensitas_penggunaan' => $request->intensitas_penggunaan,
            'usia_aset' => $request->usia_aset,
            'label_kondisi' => $request->label_kondisi,
        ];
    }

    DataLatih::create($data);

    return redirect('/data-latih')->with('success', 'Data latih berhasil ditambahkan');
}

    public function edit($id_data_latih)
    {
        $data = DataLatih::findOrFail($id_data_latih);
        return view('data-latih.edit', compact('data'));
    }

    public function update(Request $request, $id_data_latih)
    {
        $data = DataLatih::findOrFail($id_data_latih);
        $data->update($request->all());
        return redirect('/data-latih')->with('success', 'Data latih berhasil diperbarui');
    }

    public function destroy($id_data_latih)
    {
        DataLatih::findOrFail($id_data_latih)->delete();
        return redirect('/data-latih')->with('success', 'Data latih berhasil dihapus');
    }
}