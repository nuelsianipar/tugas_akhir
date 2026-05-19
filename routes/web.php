<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahan untuk memanggil fungsi Auth
use Illuminate\Http\Request;         // Tambahan untuk memanggil Request session
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\Api\AwsController; 
use App\Http\Controllers\Api\ArgController;

// ==========================================
// RUTE AUTENTIKASI (LOGIN & REGISTER)
// ==========================================
Route::get('/', function () { return view('login'); });
Route::get('/register', function () { return view('register'); });
Route::post('/register', [AuthController::class, 'registerPost']);
Route::post('/login', [AuthController::class, 'loginPost']);

// Menambahkan rute POST untuk Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // Kembali ke halaman login ('/') dengan pesan sukses
    return redirect('/')->with('sukses', 'Anda berhasil logout!');
});

// ==========================================
// RUTE HOME UMUM
// ==========================================
Route::get('/home', function () { return view('home'); });

// ==========================================
// RUTE DASHBOARD CUACA (Peta & Detail Sensor)
// ==========================================

// 1. Menampilkan Peta Interaktif (Halaman Utama Dashboard)
Route::get('/dashboard', [DashboardController::class, 'index']);

// 2. Menampilkan Kotak Sensor (Saat bulatan di peta diklik)
Route::get('/dashboard/detail/{id_alat}', [DashboardController::class, 'detail']);

// 3. Rute untuk halaman Menu Data
Route::get('/data', [DashboardController::class, 'halamanData']);

// ==========================================
// 🚀 RUTE API UNTUK AJAX (AUTO-REFRESH PETA)
// ==========================================
// Jalur belakang biar peta bisa ngecek warna merah/hijau tiap 3 detik
Route::get('/api/status-peta', [DashboardController::class, 'getStatusPeta']);