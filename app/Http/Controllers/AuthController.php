<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return back()->withErrors(['username' => 'Username atau password salah']);
        }

        session([
            'id_pengguna' => $pengguna->id_pengguna,
            'nama_pengguna' => $pengguna->nama_pengguna,
            'role' => $pengguna->role,
        ]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}