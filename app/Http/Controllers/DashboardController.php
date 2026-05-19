<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    // ==============================================================
    // 1. FUNGSI UNTUK MENAMPILKAN PETA SEBARAN (DASHBOARD)
    // ==============================================================
    public function index()
    {
        return view('dashboard');
    }

    // ==============================================================
    // 🚀 1.5 FUNGSI API AJAX UNTUK AUTO-UPDATE PETA LEAFLET
    // ==============================================================
    public function getStatusPeta()
    {
        // 👉 OBAT SAKTI: Sekarang ngambil daftar stasiun LANGSUNG dari Database MySQL!
        $daftarAlat = DB::table('daftar_peralatan')->get();

        $lokasiPeralatan = [];

        foreach ($daftarAlat as $alat) {
            // Cek apakah nama stasiun ada unsur ARG, PJT, atau PH
            $nama_kecil = strtolower($alat->nama_peralatan);
            $isArg = (strpos($nama_kecil, 'arg') !== false || strpos($nama_kecil, 'pjt') !== false || strpos($nama_kecil, 'ph') !== false);
            $namaTabel = $isArg ? 'data_arg' : 'data_aws';

            // Tarik data terakhir dari sensor
            $dataTerakhir = DB::table($namaTabel) 
                ->where('id_peralatan', $alat->id_peralatan)
                ->orderBy('waktu_observasi', 'desc')
                ->first();

            $status = 1; 
            $jenis_anomali = []; 
            $waktu_anomali = '-';

            if ($dataTerakhir) {
                // Konversi angka QC
                $qc_range = isset($dataTerakhir->status_qc_range) ? (int)$dataTerakhir->status_qc_range : 1;
                $qc_step  = isset($dataTerakhir->status_qc_step) ? (int)$dataTerakhir->status_qc_step : 1;
                $flag_missing = isset($dataTerakhir->flag_missing) ? (int)$dataTerakhir->flag_missing : 0;
                
                $param_anomali = isset($dataTerakhir->parameter_anomali) ? $dataTerakhir->parameter_anomali : null;

                if ($qc_range === 0) $jenis_anomali[] = "Range Check";
                if ($qc_step === 0) $jenis_anomali[] = "Step Check";
                if ($flag_missing === 1) $jenis_anomali[] = "Missing Data";

                // SAKLAR OTOMATIS: Kalau ada tulisan parameternya, PAKSA merah!
                if (!empty($param_anomali)) {
                    $jenis_anomali[] = "Info: " . $param_anomali;
                    $status = 0; 
                }

                // Jika array anomali ada isinya, matikan status jadi 0
                if (!empty($jenis_anomali)) {
                    $status = 0; 
                    $waktu_anomali = \Carbon\Carbon::parse($dataTerakhir->waktu_observasi)->format('H:i:s');
                }
            } else {
                // Kalau datanya KOSONG BLONG (belum pernah ngirim data sama sekali)
                $status = 0;
                $jenis_anomali[] = "Belum Ada Data Masuk";
            }

            // Susun JSON untuk dikirim ke peta HTML
            $lokasiPeralatan[] = [
                'id_alat'       => $alat->id_peralatan,
                'site'          => $alat->nama_peralatan,
                'lat'           => $alat->latitude, 
                'lon'           => $alat->longitude,
                'status'        => $status, 
                'info_anomali'  => implode(' | ', array_unique($jenis_anomali)), 
                'waktu_anomali' => $waktu_anomali
            ];
        }

        return response()->json($lokasiPeralatan);
    }

    // ==============================================================
    // 2. FUNGSI UNTUK MENAMPILKAN DETAIL SENSOR (DASHBOARD INDIVIDU)
    // ==============================================================
    public function detail($id_alat)
    {
        $stasiun = DB::table('daftar_peralatan')->where('id_peralatan', $id_alat)->first();
        $nama_site = $stasiun ? $stasiun->nama_peralatan : 'Unknown Site';
        
        $nama_kecil = strtolower($nama_site);
        $jenis_alat = 'AWS'; 
        if (strpos($nama_kecil, 'arg') !== false || strpos($nama_kecil, 'pjt') !== false || strpos($nama_kecil, 'ph') !== false) {
            $jenis_alat = 'ARG'; 
        }

        $namaTabel = ($jenis_alat == 'ARG') ? 'data_arg' : 'data_aws';

        // 1. Tarik 1 data paling baru buat angka gede di kotak atas
        $dataTerakhir = DB::table($namaTabel)
            ->where('id_peralatan', $id_alat)
            ->orderBy('waktu_observasi', 'desc')
            ->first();

        // 👉 2. TAMBAHAN BARU: Tarik 15 data terakhir buat digambar di Grafik!
        $riwayatData = DB::table($namaTabel)
            ->where('id_peralatan', $id_alat)
            ->orderBy('waktu_observasi', 'desc')
            ->limit(15)
            ->get()
            ->reverse()
            ->values(); // Direverse biar urutan waktu di grafik dari kiri (lama) ke kanan (baru)

        $dataSensor = $dataTerakhir;
        $is_anomali = false;
        $pesan_anomali = '';

        if ($dataTerakhir) {
            $list_error = [];
            if (isset($dataTerakhir->status_qc_range) && $dataTerakhir->status_qc_range == 0) $list_error[] = "Range Check Error";
            if (isset($dataTerakhir->status_qc_step) && $dataTerakhir->status_qc_step == 0) $list_error[] = "Step Check Error";
            if (isset($dataTerakhir->flag_missing) && $dataTerakhir->flag_missing == 1) $list_error[] = "Data Missing";
            
            if (!empty($dataTerakhir->parameter_anomali)) {
                $list_error[] = "Parameter: " . $dataTerakhir->parameter_anomali;
            }

            if (count($list_error) > 0) {
                $is_anomali = true;
                $pesan_anomali = implode(' | ', array_unique($list_error));
            }
        }

        // 👉 Jangan lupa variabel $riwayatData wajib diselipin ke compact() biar sampai ke HTML
        return view('dashboard_detail', compact('id_alat', 'nama_site', 'jenis_alat', 'dataTerakhir', 'dataSensor', 'is_anomali', 'pesan_anomali', 'riwayatData'));
    }

    // ==============================================================
    // 3. FUNGSI UNTUK HALAMAN TABEL DATA KESELURUHAN
    // ==============================================================
    public function halamanData()
    {
        $logDataAWS = DB::table('data_aws')
            ->orderBy('waktu_observasi', 'desc')
            ->limit(1000) 
            ->get();

        $logDataARG = DB::table('data_arg')
            ->orderBy('waktu_observasi', 'desc') 
            ->limit(1000)
            ->get();

        return view('data_page', compact('logDataAWS', 'logDataARG'));
    }
}