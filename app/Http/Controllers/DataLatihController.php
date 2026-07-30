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
        $dataAset = DataAset::all();
        return view('data-latih.create', compact('dataAset'));
    }

    public function store(Request $request)
    {
        $data = [];

        if ($request->mode == 'aset' && $request->id_aset) {
            $aset = DataAset::findOrFail($request->id_aset);

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

    public function generateOtomatis(Request $request)
    {
        // Ambil semua id_aset yang SUDAH ada di data_latih, biar tidak dobel
        $idAsetSudahAda = DataLatih::whereNotNull('id_aset')->pluck('id_aset')->toArray();

        // Ambil semua data aset yang sudah punya kondisi & belum ada di data latih
        $daftarAset = DataAset::whereNotNull('kondisi_aset')
            ->where('kondisi_aset', '!=', '')
            ->whereNotIn('id_aset', $idAsetSudahAda)
            ->get();

        $jumlahBerhasil = 0;

        foreach ($daftarAset as $aset) {
            $tahunPerolehan = (int) date('Y', strtotime($aset->tahun_perolehan));

            DataLatih::create([
                'id_aset' => $aset->id_aset,
                'jenis_aset' => $aset->jenis_aset,
                'intensitas_penggunaan' => $aset->intensitas_penggunaan,
                'usia_aset' => (int) date('Y') - $tahunPerolehan,
                'label_kondisi' => $aset->kondisi_aset,
            ]);

            $jumlahBerhasil++;
        }

        if ($jumlahBerhasil == 0) {
            return redirect('/data-latih')->with('success', 'Tidak ada data aset baru yang bisa ditambahkan. Semua aset yang sudah punya kondisi sudah ada di Data Latih, atau belum ada aset yang diklasifikasi kondisinya.');
        }

        return redirect('/data-latih')->with('success', "Berhasil generate {$jumlahBerhasil} data latih otomatis dari Data Aset.");
    }

    public function resetGenerate(Request $request)
{
    // Hapus SEMUA data latih yang ada (baik manual maupun otomatis)
    DataLatih::truncate();

    // Ambil semua data aset yang sudah punya kondisi
    $daftarAset = DataAset::whereNotNull('kondisi_aset')
        ->where('kondisi_aset', '!=', '')
        ->get();

    $jumlahBerhasil = 0;

    foreach ($daftarAset as $aset) {
        $tahunPerolehan = (int) date('Y', strtotime($aset->tahun_perolehan));

        DataLatih::create([
            'id_aset' => $aset->id_aset,
            'jenis_aset' => $aset->jenis_aset,
            'intensitas_penggunaan' => $aset->intensitas_penggunaan,
            'usia_aset' => (int) date('Y') - $tahunPerolehan,
            'label_kondisi' => $aset->kondisi_aset,
        ]);

        $jumlahBerhasil++;
    }

    return redirect('/data-latih')->with('success', "Semua data latih lama sudah dihapus. Berhasil generate ulang {$jumlahBerhasil} data latih dari Data Aset.");
}
}