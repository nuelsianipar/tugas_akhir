<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAws extends Model
{
    use HasFactory;

    // Arahkan ke nama tabel yang benar di database
    protected $table = 'data_aws'; 

    // Sesuaikan primary key-nya berdasarkan gambar (id_log)
    protected $primaryKey = 'id_log'; 

    // Matikan timestamps bawaan Laravel
    public $timestamps = false; 

    // DAFTARKAN SEMUA KOLOM LENGKAP AWS SESUAI GAMBAR
    protected $fillable = [
        'id_peralatan', 'waktu_observasi', 'suhu', 'kelembapan', 
        'kecepatan_angin', 'arah_angin', 'curah_hujan', 'radiasi_matahari', 
        'status_qc_range', 'status_qc_step', 'flag_missing', 
        'parameter_anomali' // 👉 TAMBAHKAN INI
    ];
}