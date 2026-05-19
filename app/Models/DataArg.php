<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataArg extends Model
{
    use HasFactory;

    // Arahkan ke tabel data_arg
    protected $table = 'data_arg';
    protected $primaryKey = 'id_log'; // Sesuaikan jika primary key-nya beda
    public $timestamps = false;

    // Daftarkan kolom yang boleh diisi (Tanpa suhu, angin, dll)
    protected $fillable = [
        'id_peralatan',
        'waktu_observasi',
        'curah_hujan',
        'baterai',
        'log_temp',
        'status_qc_range',
        'status_qc_step',
        'flag_missing',
        'parameter_anomali' // 👉 TAMBAHAN BARU (Biar Laravel ngasih izin masuk)
    ];
}