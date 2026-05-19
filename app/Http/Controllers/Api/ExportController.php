<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan DB facade
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $format = $request->query('format');
        $jenisAlat = $request->query('jenis', 'ARG'); // Default ke ARG jika tidak ada parameter

        if (!$tanggal || !$format) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Parameter tanggal dan format wajib diisi'
            ], 400);
        }

        // Tentukan tabel berdasarkan jenis alat (sesuaikan dengan logikamu)
        $namaTabel = ($jenisAlat == 'ARG') ? 'data_arg' : 'data_aws';

        // Menggunakan DB facade karena kamu sepertinya tidak menggunakan Model Eloquent
        $dataPemantauan = DB::table($namaTabel)
            ->whereDate('waktu_observasi', $tanggal)
            ->orderBy('waktu_observasi', 'asc')
            ->get();

        if ($dataPemantauan->isEmpty()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Data tidak ditemukan pada tanggal ' . $tanggal
            ], 404);
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.laporan_pdf', [
                'data' => $dataPemantauan, 
                'tanggal' => $tanggal,
                'jenis' => $jenisAlat
            ]);

            $fileName = 'laporan_' . strtolower($jenisAlat) . '_' . $tanggal . '_' . time() . '.pdf';
            $filePath = 'public/downloads/' . $fileName; 

            Storage::put($filePath, $pdf->output());

            return response()->json([
                'status' => 'success',
                'file_url' => asset('storage/downloads/' . $fileName)
            ]);
        }

        return response()->json([
            'status' => 'error', 
            'message' => 'Format saat ini belum didukung'
        ], 400);
    }
}