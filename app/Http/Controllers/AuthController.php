<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==============================================================
    // 1. FUNGSI UNTUK MEMPROSES LOGIN
    // ==============================================================
    public function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username/Email wajib diisi!',
            'password.required' => 'Password wajib diisi!'
        ]);

        // Formnya 'username', tapi di DB nyarinya di kolom 'email'
        $credentials = [
            'email'    => $request->input('username'), 
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home'); 
        }

        return back()->with('error', 'Username atau Password yang Anda masukkan salah!')->onlyInput('username');
    }

    // ==============================================================
    // 2. FUNGSI UNTUK MEMPROSES LOGOUT
    // ==============================================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==============================================================
    // 3. FUNGSI UNTUK MEMPROSES REGISTER
    // ==============================================================
    public function registerPost(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'username' => 'required|email|unique:users,email', // Cek unik ke kolom 'email'
            'no_wa'    => 'required|numeric', 
            'password' => 'required|min:6|confirmed' 
        ], [
            'username.required'  => 'Email wajib diisi!',
            'username.email'     => 'Format harus email! (contoh: dosen@mail.com)',
            'username.unique'    => 'Email ini sudah terdaftar bosku!',
            'no_wa.required'     => 'Nomor WhatsApp wajib diisi!',
            'no_wa.numeric'      => 'Nomor WhatsApp harus berupa angka!',
            'password.required'  => 'Password wajib diisi!',
            'password.min'       => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!'
        ]);

        // 👉 JURUS NINJA: Bikin nama dinamis dari potongan email sebelum tanda '@'
        // Contoh: "budi@gmail.com" bakal otomatis jadi nama "budi"
        $namaDinamis = explode('@', $request->username)[0];

        // 2. SIMPAN KE DATABASE (SESUAIKAN DENGAN STRUKTUR KOLOM DI GAMBAR)
        User::create([
            'name'     => $namaDinamis,        // Masuk ke kolom 'name'
            'email'    => $request->username,  // Masuk ke kolom 'email'
            'no_wa'    => $request->no_wa,     // Masuk ke kolom 'no_wa'
            'password' => Hash::make($request->password), 
        ]);

        // 3. SUKSES: Arahkan ke halaman Login
        return redirect('/')->with('sukses', 'Registrasi berhasil! Silakan login bosku.');
    }
}