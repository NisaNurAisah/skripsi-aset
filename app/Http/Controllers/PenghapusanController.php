<?php

namespace App\Http\Controllers;

use App\Models\Penghapusan;
use App\Models\DataAset;
use Illuminate\Http\Request;

class PenghapusanController extends Controller
{
    public function index(Request $request)
{
    $query = Penghapusan::with('aset');

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->whereHas('aset', function($q2) use ($request) {
                $q2->where('nama_aset', 'like', '%' . $request->search . '%');
            })->orWhere('alasan_penghapusan', 'like', '%' . $request->search . '%');
        });
    }

    $penghapusan = $query->get();
    return view('penghapusan.index', compact('penghapusan'));
}

    public function create()
    {
        $dataAset = DataAset::all();
        return view('penghapusan.create', compact('dataAset'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_aset' => 'required',
            'tanggal_penghapusan' => 'required|date',
            'alasan_penghapusan' => 'required',
        ]);

        Penghapusan::create(array_merge($request->all(), [
            'id_pengguna' => session('id_pengguna'),
            'status' => 'Diajukan',
        ]));

        return redirect('/penghapusan')->with('success', 'Data penghapusan berhasil ditambahkan');
    }

    public function destroy($id_penghapusan)
    {
        Penghapusan::findOrFail($id_penghapusan)->delete();
        return redirect('/penghapusan')->with('success', 'Data penghapusan berhasil dihapus');
    }

    public function approve($id_penghapusan)
{
    $penghapusan = Penghapusan::findOrFail($id_penghapusan);
    $penghapusan->update(['status' => 'Disetujui']);
    return redirect('/penghapusan')->with('success', 'Penghapusan aset disetujui.');
}

public function reject($id_penghapusan)
{
    $penghapusan = Penghapusan::findOrFail($id_penghapusan);
    $penghapusan->update(['status' => 'Ditolak']);
    return redirect('/penghapusan')->with('success', 'Penghapusan aset ditolak.');
}
}