<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileSettingController extends Controller
{
    public function edit()
    {
        $pengguna = Pengguna::findOrFail(session('id_pengguna'));
        return view('profile-setting.edit', compact('pengguna'));
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'username' => 'required|unique:pengguna,username,' . session('id_pengguna') . ',id_pengguna',
        ]);

        $pengguna = Pengguna::findOrFail(session('id_pengguna'));
        $pengguna->update([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
        ]);

        session(['nama_pengguna' => $pengguna->nama_pengguna]);

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $pengguna = Pengguna::findOrFail(session('id_pengguna'));

        if (!Hash::check($request->password_lama, $pengguna->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah.']);
        }

        $pengguna->update(['password' => Hash::make($request->password_baru)]);

        return redirect('/profile')->with('success', 'Password berhasil diubah.');
    }
}