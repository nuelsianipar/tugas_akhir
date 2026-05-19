<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataArg; 
use Carbon\Carbon; 

class ArgController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            DataArg::create([
                'id_peralatan'     => $data['id_stasiun'] ?? 11,
                'waktu_observasi'  => isset($data['waktu_observasi']) ? Carbon::parse($data['waktu_observasi'])->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s'),
                
                'curah_hujan'      => $data['curah_hujan'] ?? 0,
                'baterai'          => $data['baterai'] ?? 0,
                'log_temp'         => $data['log_temp'] ?? 0,

                'status_qc_range'  => $data['status_qc_range'] ?? 1,
                'status_qc_step'   => $data['status_qc_step'] ?? 1,
                'flag_missing'     => $data['flag_missing'] ?? 0,
                
                // 👉 TAMBAHAN BARU: Simpan nama parameter yang error dari Node-RED ke MySQL
                'parameter_anomali'=> $data['parameter_anomali'] ?? null
            ]);

            return response()->json([
                'status' => 'sukses',
                'pesan'  => 'Data ARG (Asli/Imputasi) berhasil disimpan ke Database!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Gagal menyimpan data ARG: ' . $e->getMessage()
            ], 500);
        }
    }
}