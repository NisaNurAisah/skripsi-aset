<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DataAset;
use App\Models\KategoriAset;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with('aset')->orderBy('created_at', 'desc')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $kategori = KategoriAset::all();
        $lokasi = Lokasi::all();
        return view('pembelian.create', compact('kategori', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:data_aset,kode_aset',
            'nama_aset' => 'required',
            'id_kategori' => 'required',
            'id_lokasi' => 'required',
            'tahun_perolehan' => 'required|date',
            'jumlah_pembelian' => 'required|numeric|min:1',
            'total_harga' => 'required|numeric',
            'tanggal_pembelian' => 'required|date',
            'gambar_aset' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $nilaiPerolehanPerUnit = $request->total_harga / $request->jumlah_pembelian;

            $dataAset = [
                'kode_aset' => $request->kode_aset,
                'nama_aset' => $request->nama_aset,
                'id_kategori' => $request->id_kategori,
                'id_lokasi' => $request->id_lokasi,
                'jenis_aset' => $request->jenis_aset,
                'intensitas_penggunaan' => $request->intensitas_penggunaan,
                'tahun_perolehan' => $request->tahun_perolehan,
                'nilai_perolehan' => $nilaiPerolehanPerUnit,
                'jumlah_aset' => $request->jumlah_pembelian,
                'status_aset' => 'Aktif',
            ];

            if ($request->hasFile('gambar_aset')) {
                $dataAset['gambar_aset'] = $request->file('gambar_aset')->store('aset', 'public');
            }

            $aset = DataAset::create($dataAset);

            Pembelian::create([
                'id_aset' => $aset->id_aset,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'jumlah_pembelian' => $request->jumlah_pembelian,
                'total_harga' => $request->total_harga,
            ]);
        });

        return redirect('/pembelian')->with('success', 'Pembelian berhasil dicatat dan aset baru berhasil ditambahkan ke Data Aset.');
    }

    public function destroy($id_pembelian)
    {
        Pembelian::findOrFail($id_pembelian)->delete();
        return redirect('/pembelian')->with('success', 'Data pembelian berhasil dihapus');
    }
}