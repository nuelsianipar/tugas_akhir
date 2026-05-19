<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Monitoring Cuaca Jabar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #edf2f9;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            padding: 1.5rem;
        }
        
        /* PENTING: Fitur Scroll Tabel ke Bawah */
        .table-scrollable {
            max-height: 400px; /* Batas tinggi tabel sebelum muncul scroll */
            overflow-y: auto;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        
        /* Sticky Header: Header tabel diam saat di-scroll */
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            color: #495057;
            z-index: 1;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <div class="dashboard-header text-center">
        <h2>🌤️ Dashboard Monitoring Data Cuaca Jawa Barat</h2>
        <p class="mb-0">Sistem Telemetri Otomatis (AWS & ARG)</p>
    </div>

    <div class="container-fluid px-4">
        
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-primary">📡 Data Automatic Weather Station (AWS)</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-scrollable">
                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Suhu (°C)</th>
                                <th>Kelembapan (%)</th>
                                <th>Kecepatan Angin (m/s)</th>
                                <th>Arah Angin (°)</th>
                                <th>Curah Hujan (mm)</th>
                                <th>Radiasi Matahari (W/m²)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataAws as $index => $aws)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ \Carbon\Carbon::parse($aws->waktu_observasi)->format('d-M-Y H:i') }}</strong></td>
                                <td>{{ $aws->suhu ?? '-' }}</td>
                                <td>{{ $aws->kelembapan ?? '-' }}</td>
                                <td>{{ $aws->kecepatan_angin ?? '-' }}</td>
                                <td>{{ $aws->arah_angin ?? '-' }}</td>
                                <td><span class="badge bg-info text-dark">{{ $aws->curah_hujan ?? '-' }} mm</span></td>
                                <td>{{ $aws->radiasi_matahari ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Data AWS belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-success">🌧️ Data Automatic Rain Gauge (ARG)</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-scrollable">
                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Curah Hujan (mm)</th>
                                <th>Baterai (V)</th>
                                <th>Log Temp (°C)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataArg as $index => $arg)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ \Carbon\Carbon::parse($arg->waktu_observasi)->format('d-M-Y H:i') }}</strong></td>
                                <td><span class="badge bg-primary">{{ $arg->curah_hujan ?? '-' }} mm</span></td>
                                <td class="{{ $arg->baterai < 11.5 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                    {{ $arg->baterai ?? '-' }} V
                                </td>
                                <td>{{ $arg->log_temp ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Data ARG belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>