<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'username' => 'required|unique:pengguna,username',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'Aktif',
        ]);

        return redirect('/data-pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function destroy($id_pengguna)
    {
        Pengguna::findOrFail($id_pengguna)->delete();
        return redirect('/data-pengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}