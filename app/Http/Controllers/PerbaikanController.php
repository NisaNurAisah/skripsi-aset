<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\DataAset;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index(Request $request)
{
    $query = Perbaikan::with('aset');

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->whereHas('aset', function($q2) use ($request) {
                $q2->where('nama_aset', 'like', '%' . $request->search . '%');
            })->orWhere('deskripsi_kerusakan', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $perbaikan = $query->get();
    return view('perbaikan.index', compact('perbaikan'));
}

    public function create()
    {
        $dataAset = DataAset::all();
        return view('perbaikan.create', compact('dataAset'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_aset' => 'required',
            'deskripsi_kerusakan' => 'required',
            'tanggal_perbaikan' => 'required|date',
        ]);

        Perbaikan::create(array_merge($request->all(), [
            'id_pengguna' => session('id_pengguna'),
            'status' => 'Diajukan',
        ]));

        return redirect('/perbaikan')->with('success', 'Data perbaikan berhasil ditambahkan');
    }

    public function destroy($id_perbaikan)
    {
        Perbaikan::findOrFail($id_perbaikan)->delete();
        return redirect('/perbaikan')->with('success', 'Data perbaikan berhasil dihapus');
    }

    public function approve($id_perbaikan)
{
    $perbaikan = Perbaikan::findOrFail($id_perbaikan);
    $perbaikan->update(['status' => 'Disetujui']);
    return redirect('/perbaikan')->with('success', 'Perbaikan aset disetujui.');
}

public function reject($id_perbaikan)
{
    $perbaikan = Perbaikan::findOrFail($id_perbaikan);
    $perbaikan->update(['status' => 'Ditolak']);
    return redirect('/perbaikan')->with('success', 'Perbaikan aset ditolak.');
}
}