<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataAws; 
use Carbon\Carbon; 

class AwsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            // LANGSUNG SIMPAN APAPUN YANG DIKIRIM NODE-RED!
            // Entah itu data asli atau data hasil tebakan Imputasi.
            DataAws::create([
                'id_peralatan'     => $data['id_stasiun'] ?? 6,
                'waktu_observasi'  => isset($data['waktu_observasi']) ? Carbon::parse($data['waktu_observasi'])->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s'),
                
                'suhu'             => $data['suhu'] ?? 0,
                'kelembapan'       => $data['kelembapan'] ?? 0,
                'kecepatan_angin'  => $data['kecepatan_angin'] ?? 0,
                'arah_angin'       => $data['arah_angin'] ?? 0,
                'curah_hujan'      => $data['curah_hujan'] ?? 0,
                'radiasi_matahari' => $data['radiasi_matahari'] ?? 0,

                'status_qc_range'  => $data['status_qc_range'] ?? 1,
                'status_qc_step'   => $data['status_qc_step'] ?? 1,
                'flag_missing'     => $data['flag_missing'] ?? 0,

                // 👉 TAMBAHAN BARU: Simpan nama parameter yang error dari Node-RED ke MySQL
                'parameter_anomali'=> $data['parameter_anomali'] ?? null
            ]);

            return response()->json([
                'status' => 'sukses',
                'pesan'  => 'Data AWS (Asli/Imputasi) berhasil disimpan ke Database!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Gagal menyimpan data AWS: ' . $e->getMessage()
            ], 500);
        }
    }
}