<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title>Detail - {{ $nama_site }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
   <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'ABeeZee', sans-serif; }
        body { background-color: #FFFFFF; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 10px; }
        
        .home-container { 
            display: flex; 
            width: 100%; 
            max-width: 1200px; 
            height: 95vh; 
            background: rgba(255, 245, 245, 0.15); 
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); 
            border-radius: 20px; 
            overflow: hidden; 
        }

        .sidebar { width: 220px; background: #9AFCFF; display: flex; flex-direction: column; padding-top: 30px; border-right: 1px solid rgba(0,0,0,0.1); z-index: 10; flex-shrink: 0;}
        .sidebar-logos { display: flex; justify-content: space-evenly; align-items: center; margin-bottom: 40px; }
        .logo-small { width: 65px; height: 65px; display: flex; justify-content: center; align-items: center; }
        .logo-small img { width: 100%; height: 100%; object-fit: contain; }
        
        .nav-menu { display: flex; flex-direction: column; flex-grow: 1; }
        .nav-item { display: flex; align-items: center; padding: 15px 25px; text-decoration: none; color: #000000; font-size: 18px; border-bottom: 1px solid #000000; transition: 0.3s; }
        .nav-item.active, .nav-item:hover { background-color: rgba(255,255,255,0.4); font-weight: bold;}
        .nav-item.first-item { border-top: 1px solid #000000; }
        
        .logout-btn { display: flex; align-items: center; padding: 15px 25px; text-decoration: none; color: #000000; font-size: 18px; border-top: 1px solid #000000; margin-bottom: 20px; cursor: pointer; border: none; background: none; text-align: left; width: 100%;}
        .logout-btn:hover { background-color: #ffcccc; }

        .main-content { flex: 1; display: flex; flex-direction: column; padding: 25px; background-color: #FAFAFA; position: relative; overflow-y: auto; }
        
        .main-content::-webkit-scrollbar { width: 8px; }
        .main-content::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .main-content::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        .main-content::-webkit-scrollbar-thumb:hover { background: #9AFCFF; }

        .header-detail { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #ddd; padding-bottom: 10px; flex-shrink: 0;}
        .header-detail h2 { font-weight: bold; color: #333; font-size: 20px; }
        .btn-back { background: #333; padding: 8px 15px; border-radius: 8px; text-decoration: none; color: #fff; font-size: 13px; transition: 0.3s; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); white-space: nowrap;}
        .btn-back:hover { background: #555; }

        .alert-box { background-color: #ffe6e6; border-left: 5px solid #ff4d4d; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; color: #cc0000; font-weight: bold; flex-shrink: 0;}
        .time-container { display: flex; gap: 15px; margin-bottom: 20px; justify-content: center; flex-wrap: wrap; flex-shrink: 0;}
        .time-pill { background-color: #e9ecef; padding: 6px 20px; border-radius: 15px; font-size: 13px; font-weight: bold; color: #444; border: 1px solid #ccc; white-space: nowrap;}

        .grid-container { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); 
            gap: 20px; 
            padding-bottom: 20px; 
        }

        .card-combined { 
            background: #fff; 
            padding: 15px 20px; 
            border-radius: 15px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
            display: flex; 
            flex-direction: column; 
            height: 280px; 
            transition: transform 0.2s;
        }
        .card-combined:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.1); }

        .card-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 10px; 
            border-bottom: 1px solid #f0f0f0; 
            padding-bottom: 10px; 
        }
        .card-header h3 { font-size: 16px; color: #555; font-weight: bold; display: flex; align-items: center; gap: 8px;}
        .card-header .value-wrapper { text-align: right; }
        .card-header .value { font-size: 28px; font-weight: bold; color: #222; line-height: 1;}
        .card-header .unit { font-size: 12px; color: #888; }

        .card-chart { 
            flex: 1; 
            position: relative; 
            width: 100%; 
            margin-top: 5px;
        }

        .empty-state { text-align: center; margin-top: 60px; color: #666; }
        .empty-state i { font-size: 50px; color: #ccc; margin-bottom: 15px; }

        @media (max-width: 768px) {
            body { padding: 0; }
            .home-container { height: 100vh; flex-direction: column; border-radius: 0; }
            .sidebar { width: 100%; height: auto; padding-top: 10px; border-right: none; border-bottom: 2px solid #ddd; }
            .sidebar-logos { display: none; }
            .nav-menu { flex-direction: row; overflow-x: auto; padding-bottom: 5px; }
            .nav-item { padding: 8px 15px; font-size: 14px; border: none !important; white-space: nowrap; }
            .logout-btn { padding: 8px 15px; font-size: 14px; margin: 0; border: none; white-space: nowrap; }
            .main-content { padding: 15px; }
            .header-detail { flex-direction: column; align-items: flex-start; gap: 10px; }
            h2 { font-size: 18px; }
            .grid-container { grid-template-columns: 1fr; } 
        }
    </style>
</head>
<body>

    <div class="home-container">
        <div class="sidebar">
            <div class="sidebar-logos">
                <div class="logo-small"><img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="BMKG"></div>
                <div class="logo-small"><img src="https://3.bp.blogspot.com/-BRV8kAVyi4I/XDX3S86Pk5I/AAAAAAAABwA/K5fnfc4c1VYps0EcV32qP6yB96kghqU3QCLcBGAs/s1600/logo%2Bjawa%2Bbarat.png" alt="JABAR"></div>
            </div>
            <div class="nav-menu">
                <a href="{{ url('/home') }}" class="nav-item first-item">🏠 Home</a>
                <a href="{{ url('/dashboard') }}" class="nav-item active">📊 Dashboard</a>
                <a href="{{ url('/data') }}" class="nav-item">🗄️ Data</a>
            </div>
            <form action="{{ url('/logout') }}" method="POST" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="logout-btn">🚪 Log out</button>
            </form>
        </div>

        <div class="main-content">
            <div class="header-detail">
                <h2>{{ $nama_site }}</h2>
                <a href="{{ url('/dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Map</a>
            </div>

            @if($dataTerakhir)
                @php $waktu_observasi = \Carbon\Carbon::parse($dataTerakhir->waktu_observasi); @endphp

                @if(isset($is_anomali) && $is_anomali)
                    <div class="alert-box"><i class="fas fa-exclamation-triangle"></i> Terjadi Anomali ({{ $pesan_anomali }})</div>
                @endif

                <div class="time-container">
                    <div class="time-pill"><i class="fas fa-calendar-alt"></i> Tanggal : {{ $waktu_observasi->format('d-m-Y') }}</div>
                    <div class="time-pill"><i class="fas fa-clock"></i> Waktu : {{ $waktu_observasi->format('H:i:s') }} WIB</div>
                </div>

                <div class="grid-container">
                    @if($jenis_alat == 'AWS')
                        <div class="card-combined" style="border-left: 5px solid #e74c3c;">
                            <div class="card-header">
                                <h3><i class="fas fa-thermometer-half" style="color: #e74c3c;"></i> Suhu</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->suhu) ? number_format((float)$dataTerakhir->suhu, 2) : '-' }}</div>
                                    <div class="unit">°C</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="suhuChart"></canvas></div>
                        </div>
                        
                        <div class="card-combined" style="border-left: 5px solid #3498db;">
                            <div class="card-header">
                                <h3><i class="fas fa-tint" style="color: #3498db;"></i> Kelembapan</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->kelembapan) ? number_format((float)$dataTerakhir->kelembapan, 2) : '-' }}</div>
                                    <div class="unit">%</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="kelembapanChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #2ecc71;">
                            <div class="card-header">
                                <h3><i class="fas fa-cloud-showers-heavy" style="color: #2ecc71;"></i> Curah Hujan</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->curah_hujan) ? number_format((float)$dataTerakhir->curah_hujan, 2) : '0' }}</div>
                                    <div class="unit">mm</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="hujanChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #9b59b6;">
                            <div class="card-header">
                                <h3><i class="fas fa-wind" style="color: #9b59b6;"></i> Kec. Angin</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->kecepatan_angin) ? number_format((float)$dataTerakhir->kecepatan_angin, 2) : '-' }}</div>
                                    <div class="unit">m/s</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="anginChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #34495e;">
                            <div class="card-header">
                                <h3><i class="fas fa-compass" style="color: #34495e;"></i> Arah Angin</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->arah_angin) ? number_format((float)$dataTerakhir->arah_angin, 2) : '-' }}</div>
                                    <div class="unit">Derajat (°)</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="arahChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #f1c40f;">
                            <div class="card-header">
                                <h3><i class="fas fa-sun" style="color: #f1c40f;"></i> Radiasi Matahari</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->radiasi_matahari) ? number_format((float)$dataTerakhir->radiasi_matahari, 2) : '-' }}</div>
                                    <div class="unit">W/m²</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="radiasiChart"></canvas></div>
                        </div>
                    @endif

                    @if($jenis_alat == 'ARG')
                        <div class="card-combined" style="border-left: 5px solid #2ecc71;">
                            <div class="card-header">
                                <h3><i class="fas fa-cloud-showers-heavy" style="color: #2ecc71;"></i> Curah Hujan</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->curah_hujan) ? number_format((float)$dataTerakhir->curah_hujan, 2) : '0' }}</div>
                                    <div class="unit">mm</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="hujanArgChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #e67e22;">
                            <div class="card-header">
                                <h3><i class="fas fa-battery-three-quarters" style="color: #e67e22;"></i> Teg. Baterai</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->baterai) ? number_format((float)$dataTerakhir->baterai, 2) : '-' }}</div>
                                    <div class="unit">Volt</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="bateraiChart"></canvas></div>
                        </div>

                        <div class="card-combined" style="border-left: 5px solid #e74c3c;">
                            <div class="card-header">
                                <h3><i class="fas fa-temperature-low" style="color: #e74c3c;"></i> Suhu Logger</h3>
                                <div class="value-wrapper">
                                    <div class="value">{{ isset($dataTerakhir->log_temp) ? number_format((float)$dataTerakhir->log_temp, 2) : '-' }}</div>
                                    <div class="unit">°C</div>
                                </div>
                            </div>
                            <div class="card-chart"><canvas id="suhuLogChart"></canvas></div>
                        </div>
                    @endif
                </div>

            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data masuk untuk stasiun ini.</p>
                </div>
            @endif

        </div>
    </div>

    @if($dataTerakhir)
    <script>
        Chart.defaults.font.family = "'ABeeZee', sans-serif";

        // SEKARANG MENGAMBIL DATA ASLI 100% DARI MYSQL
        let riwayatData = @json($riwayatData ?? []);
        const jenisAlat = "{{ $jenis_alat }}";

        const labels = riwayatData.map(item => {
            let date = new Date(item.waktu_observasi);
            return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
        });

        function createCardChart(canvasId, dataArray, hexColor) {
            const canvas = document.getElementById(canvasId);
            if(!canvas) return;
            const ctx = canvas.getContext('2d');
            
            let gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, hexColor + '66'); 
            gradient.addColorStop(1, hexColor + '00'); 

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataArray, 
                        borderColor: hexColor,
                        backgroundColor: gradient,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4, 
                        pointRadius: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: hexColor
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { 
                        x: { display: true, grid: { display: false } }, 
                        y: { display: true, border: { display: false }, grid: { color: '#f5f5f5' } } 
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });
        }

        if(jenisAlat === 'AWS') {
            createCardChart('suhuChart', riwayatData.map(d => d.suhu), '#e74c3c');
            createCardChart('kelembapanChart', riwayatData.map(d => d.kelembapan), '#3498db');
            createCardChart('hujanChart', riwayatData.map(d => d.curah_hujan), '#2ecc71');
            createCardChart('anginChart', riwayatData.map(d => d.kecepatan_angin), '#9b59b6');
            createCardChart('arahChart', riwayatData.map(d => d.arah_angin), '#34495e');
            createCardChart('radiasiChart', riwayatData.map(d => d.radiasi_matahari), '#f1c40f');
        } else if (jenisAlat === 'ARG') {
            createCardChart('hujanArgChart', riwayatData.map(d => d.curah_hujan), '#2ecc71');
            createCardChart('bateraiChart', riwayatData.map(d => d.baterai), '#e67e22');
            createCardChart('suhuLogChart', riwayatData.map(d => d.log_temp), '#e74c3c');
        }

    </script>
    @endif
</body>
</html>