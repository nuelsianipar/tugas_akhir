<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Data Historis - SIPANCAR</title>
    
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'ABeeZee', sans-serif; }
        body { background-color: #FFFFFF; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 10px; }
        
        .home-container { 
            display: flex; 
            width: 100%; 
            max-width: 1100px; 
            height: 90vh; 
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
        
        .logout-btn { display: flex; align-items: center; padding: 15px 25px; text-decoration: none; color: #000000; font-size: 18px; border-top: 1px solid #000000; margin-bottom: 20px; transition: 0.3s; cursor: pointer; border: none; background: transparent; text-align: left; width: 100%; font-family: 'ABeeZee', sans-serif;}
        .logout-btn:hover { background-color: #ffcccc; }

        .main-content { flex: 1; display: flex; flex-direction: column; padding: 25px; background-color: #FAFAFA; position: relative; overflow: hidden; }
        h2 { margin-bottom: 5px; font-weight: bold; color: #000000; font-size: 24px; }
        p.subtitle { font-size: 13px; color: #666; margin-bottom: 15px; }

        /* TAB KONTROL */
        .tab-container { display: flex; gap: 10px; margin-bottom: 15px; }
        .tab-btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px; font-weight: bold; transition: 0.3s; background: #eee; color: #555; }
        .tab-btn.active { background: #3498db; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

        .table-wrapper { 
            flex: 1; 
            position: relative; 
            border-radius: 10px; 
            border: 1px solid #ddd; 
            background: #fff; 
            display: none; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            padding: 15px;
        }
        .table-wrapper.active { display: block; }
        
        /* Modifikasi Table agar rapi untuk banyak kolom */
        table.dataTable { width: 100% !important; border-collapse: collapse; text-align: center; }
        th, td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #eee; color: #333; white-space: nowrap; vertical-align: middle;}
        th { background-color: #f8f9fa; color: #000; font-weight: bold; border-bottom: 2px solid #ddd !important; }
        
        tr { background-color: #fff; transition: 0.2s; }
        tr:hover { background-color: #f1f8ff; }
        
        /* Desain Cell Data Anomali */
        .cell-anomali { background-color: #ffe6e6 !important; color: #c0392b !important; font-weight: bold; border: 1px solid #ffcccc;}
        .label-imputasi { font-size: 9px; color: #fff; background: #e74c3c; padding: 2px 6px; border-radius: 10px; display: inline-block; margin-top: 3px; letter-spacing: 0.5px;}
        
        /* Desain Badge Status */
        .badge { padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid rgba(0,0,0,0.1); }
        .badge-normal { background: #D4EDDA; color: #155724; }
        .badge-range { background: #F8D7DA; color: #721C24; }
        .badge-step { background: #FFF3CD; color: #856404; }
        .badge-missing { background: #D1ECF1; color: #0C5460; }
        
        /* Desain DataTables Export Buttons */
        .dt-buttons { margin-bottom: 15px; }
        .dt-button.buttons-excel { background: #2ecc71 !important; color: white !important; border-radius: 8px !important; border: none !important; padding: 6px 15px !important; font-weight: bold; font-size: 13px;}
        .dt-button.buttons-pdf { background: #e74c3c !important; color: white !important; border-radius: 8px !important; border: none !important; padding: 6px 15px !important; font-weight: bold; font-size: 13px;}
        .dt-button:hover { opacity: 0.8 !important; }

        @media (max-width: 768px) {
            body { padding: 0; }
            .home-container { height: 100vh; flex-direction: column; border-radius: 0; }
            .sidebar { width: 100%; height: auto; padding-top: 10px; border-right: none; border-bottom: 2px solid #ddd; }
            .sidebar-logos { display: none; }
            .nav-menu { flex-direction: row; overflow-x: auto; padding-bottom: 5px; }
            .nav-item { padding: 8px 15px; font-size: 14px; border: none !important; white-space: nowrap; }
            .logout-btn { padding: 8px 15px; font-size: 14px; margin: 0; border: none; white-space: nowrap; }
            .main-content { padding: 15px; }
            h2 { font-size: 18px; }
            .tab-btn { padding: 8px 12px; font-size: 12px; }
        }
    </style>
</head>
<body>

    @php
        $daftarStasiun = [
            1 => 'UI', 2 => 'IPB', 3 => 'Cisolok', 4 => 'Cibeureum',
            5 => 'Kebun Bibit', 6 => 'Jagorawi', 7 => 'Sukaraja',
            8 => 'Sukamandi', 9 => 'Bojongpicung', 10 => 'Stageof Bandung',
            11 => 'ARG Cisadane', 12 => 'PJT II Muara', 13 => 'PJT II Jatiasih', 14 => 'PJT II Gabus', 15 => 'ARG Long Ikis'
        ];
    @endphp

    <div class="home-container">
        <div class="sidebar">
            <div class="sidebar-logos">
                <div class="logo-small"><img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="BMKG"></div>
                <div class="logo-small"><img src="https://3.bp.blogspot.com/-BRV8kAVyi4I/XDX3S86Pk5I/AAAAAAAABwA/K5fnfc4c1VYps0EcV32qP6yB96kghqU3QCLcBGAs/s1600/logo%2Bjawa%2Bbarat.png" alt="JABAR"></div>
            </div>
            <div class="nav-menu">
                <a href="{{ url('/home') }}" class="nav-item first-item">🏠 Home</a>
                <a href="{{ url('/dashboard') }}" class="nav-item">📊 Dashboard</a>
                <a href="{{ url('/data') }}" class="nav-item active">🗄️ Data</a>
            </div>
            <form action="{{ url('/logout') }}" method="POST" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="logout-btn">🚪 Log out</button>
            </form>
        </div>

        <div class="main-content">
            <h2>Data Historis Keseluruhan</h2>
            <p class="subtitle">Menampilkan seluruh data masuk. Data anomali yang dipulihkan oleh AI ditandai kotak merah.</p>
            
            <div class="tab-container">
                <button class="tab-btn active" onclick="bukaTab('aws')">📡 Data AWS</button>
                <button class="tab-btn" onclick="bukaTab('arg')">🌧️ Data ARG</button>
            </div>

            <div id="aws-table" class="table-wrapper active">
                <table id="tabelAWS" class="display nowrap table">
                    <thead>
                        <tr>
                            <th>Waktu (WIB)</th>
                            <th>Stasiun</th>
                            <th>Suhu (°C)</th>
                            <th>RH (%)</th>
                            <th>Kec. Angin (m/s)</th>
                            <th>Arah (°)</th>
                            <th>Hujan (mm)</th>
                            <th>Radiasi (W/m²)</th>
                            <th>Status Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logDataAWS as $data)
                            @php
                                $id_alat = (int) $data->id_peralatan;
                                $namaPeralatan = $daftarStasiun[$id_alat] ?? "ID: " . $data->id_peralatan;
                                $paramAnomali = $data->parameter_anomali ?? ''; 
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->waktu_observasi)->format('d-m-Y H:i') }}</td>
                                <td><b>{{ $namaPeralatan }}</b></td>
                                
                                @php $errSuhu = str_contains($paramAnomali, 'Suhu'); @endphp
                                <td class="{{ $errSuhu ? 'cell-anomali' : '' }}">
                                    {{ $data->suhu ?? '-' }}
                                    @if($errSuhu) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errRh = str_contains($paramAnomali, 'Kelembapan'); @endphp
                                <td class="{{ $errRh ? 'cell-anomali' : '' }}">
                                    {{ $data->kelembapan ?? '-' }}
                                    @if($errRh) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errWs = str_contains($paramAnomali, 'Kec. Angin'); @endphp
                                <td class="{{ $errWs ? 'cell-anomali' : '' }}">
                                    {{ $data->kecepatan_angin ?? '-' }}
                                    @if($errWs) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errWd = str_contains($paramAnomali, 'Arah Angin'); @endphp
                                <td class="{{ $errWd ? 'cell-anomali' : '' }}">
                                    {{ $data->arah_angin ?? '-' }}
                                    @if($errWd) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errRain = str_contains($paramAnomali, 'Curah Hujan'); @endphp
                                <td class="{{ $errRain ? 'cell-anomali' : '' }}">
                                    {{ $data->curah_hujan ?? '-' }}
                                    @if($errRain) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errRad = str_contains($paramAnomali, 'Radiasi Matahari'); @endphp
                                <td class="{{ $errRad ? 'cell-anomali' : '' }}">
                                    {{ $data->radiasi_matahari ?? '-' }}
                                    @if($errRad) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                <td>
                                    @if($data->flag_missing == 1) <span class="badge badge-missing">⚠️ Missing</span>
                                    @elseif($data->status_qc_range == 0) <span class="badge badge-range">❌ Range Error</span>
                                    @elseif($data->status_qc_step == 0) <span class="badge badge-step">⚡ Step Error</span>
                                    @else <span class="badge badge-normal">✅ Normal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="arg-table" class="table-wrapper">
                <table id="tabelARG" class="display nowrap table">
                    <thead>
                        <tr>
                            <th>Waktu (WIB)</th>
                            <th>Stasiun</th>
                            <th>Curah Hujan (mm)</th>
                            <th>Suhu Logger (°C)</th>
                            <th>Baterai (Volt)</th>
                            <th>Status Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logDataARG as $data)
                            @php
                                $id_alat = (int) $data->id_peralatan;
                                $namaPeralatan = $daftarStasiun[$id_alat] ?? "ID: " . $data->id_peralatan;
                                $paramAnomali = $data->parameter_anomali ?? '';
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->waktu_observasi)->format('d-m-Y H:i') }}</td>
                                <td><b>{{ $namaPeralatan }}</b></td>
                                
                                @php $errRain = str_contains($paramAnomali, 'Curah Hujan'); @endphp
                                <td class="{{ $errRain ? 'cell-anomali' : '' }}">
                                    {{ $data->curah_hujan ?? '-' }}
                                    @if($errRain) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errTemp = str_contains($paramAnomali, 'Suhu Logger'); @endphp
                                <td class="{{ $errTemp ? 'cell-anomali' : '' }}">
                                    {{ $data->log_temp ?? '-' }}
                                    @if($errTemp) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                @php $errBatt = str_contains($paramAnomali, 'Baterai'); @endphp
                                <td class="{{ $errBatt ? 'cell-anomali' : '' }}">
                                    {{ $data->baterai ?? '-' }}
                                    @if($errBatt) <br><span class="label-imputasi">Imputasi</span> @endif
                                </td>

                                <td>
                                    @if($data->flag_missing == 1) <span class="badge badge-missing">⚠️ Missing</span>
                                    @elseif($data->status_qc_range == 0) <span class="badge badge-range">❌ Range Error</span>
                                    @elseif($data->status_qc_step == 0) <span class="badge badge-step">⚡ Step Error</span>
                                    @else <span class="badge badge-normal">✅ Normal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            
            // 🛠️ MESIN PENDETEKSI IMPUTASI (ANTI GAGAL)
            var formatExport = {
                body: function (data, row, column, node) {
                    if (!data) return data;

                    // 1. Kalau di dalam kotak web ada tulisan "Imputasi"
                    if (data.toString().indexOf('label-imputasi') !== -1 || data.toString().indexOf('Imputasi') !== -1) {
                        // Bersihkan tag HTML (seperti <br>, <span>)
                        var textMurni = data.toString().replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
                        // Hapus kata 'Imputasi' bawaan web, ganti format baru
                        textMurni = textMurni.replace('Imputasi', '').trim();
                        // Format akhir yang masuk Excel & PDF
                        return '⚠️ ' + textMurni + ' (Imputasi Regresi)';
                    }

                    // 2. Kalau kotak normal (bersihkan HTML dan benerin teks statusnya)
                    var textNormal = data.toString().replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
                    return textNormal.replace('✅ Normal', 'Normal')
                                     .replace('❌ Range Error', 'Range Error')
                                     .replace('⚡ Step Error', 'Step Error')
                                     .replace('⚠️ Missing', 'Missing');
                }
            };

            // 📡 1. PENGATURAN EXPORT KHUSUS TABEL AWS
            $('#tabelAWS').DataTable({
                dom: 'Bfrtip',
                pageLength: 15, 
                scrollX: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📥 Download Excel AWS',
                        title: 'Laporan Historis Data AWS - SIPANCAR',
                        className: 'btn-export-excel',
                        exportOptions: { format: formatExport } // Masukin mesin pendeteksi ke Excel
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 Download PDF AWS',
                        title: 'Laporan Historis Data AWS - SIPANCAR',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        className: 'btn-export-pdf',
                        exportOptions: { format: formatExport }, // Masukin mesin pendeteksi ke PDF
                        customize: function (doc) {
                            doc.styles.tableHeader.alignment = 'center';
                            doc.defaultStyle.alignment = 'center';
                            
                            // 👉 SIHIR PEWARNAAN MERAH KHUSUS PDF
                            if (doc.content[1] && doc.content[1].table && doc.content[1].table.body) {
                                doc.content[1].table.body.forEach(function(row) {
                                    row.forEach(function(cell) {
                                        // Cari sel yang ada tulisan (Imputasi Regresi)
                                        if (cell.text && cell.text.toString().includes('Imputasi Regresi')) {
                                            cell.fillColor = '#ffe6e6'; // Warna background merah muda
                                            cell.color = '#c0392b';     // Warna teks merah tua
                                            cell.bold = true;           // Ditebalkan
                                        }
                                    });
                                });
                            }
                        }
                    }
                ],
                language: {
                    search: "Cari Data AWS:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data AWS",
                    paginate: { first: "Awal", last: "Akhir", next: "Maju ➡️", previous: "⬅️ Mundur" }
                }
            });

            // 🌧️ 2. PENGATURAN EXPORT KHUSUS TABEL ARG
            $('#tabelARG').DataTable({
                dom: 'Bfrtip',
                pageLength: 15, 
                scrollX: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📥 Download Excel ARG',
                        title: 'Laporan Historis Data ARG - SIPANCAR',
                        className: 'btn-export-excel',
                        exportOptions: { format: formatExport }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 Download PDF ARG',
                        title: 'Laporan Historis Data ARG - SIPANCAR',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        className: 'btn-export-pdf',
                        exportOptions: { format: formatExport },
                        customize: function (doc) {
                            doc.styles.tableHeader.alignment = 'center';
                            doc.defaultStyle.alignment = 'center';
                            
                            // 👉 SIHIR PEWARNAAN MERAH KHUSUS PDF
                            if (doc.content[1] && doc.content[1].table && doc.content[1].table.body) {
                                doc.content[1].table.body.forEach(function(row) {
                                    row.forEach(function(cell) {
                                        if (cell.text && cell.text.toString().includes('Imputasi Regresi')) {
                                            cell.fillColor = '#ffe6e6'; 
                                            cell.color = '#c0392b';     
                                            cell.bold = true;
                                        }
                                    });
                                });
                            }
                        }
                    }
                ],
                language: {
                    search: "Cari Data ARG:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data ARG",
                    paginate: { first: "Awal", last: "Akhir", next: "Maju ➡️", previous: "⬅️ Mundur" }
                }
            });
        });

        // Pindah Tab Data & Ukur Ulang Lebar Tabel
        function bukaTab(tipe) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.table-wrapper').forEach(tbl => tbl.classList.remove('active'));
            
            if(tipe === 'aws') {
                document.querySelectorAll('.tab-btn')[0].classList.add('active');
                document.getElementById('aws-table').classList.add('active');
            } else {
                document.querySelectorAll('.tab-btn')[1].classList.add('active');
                document.getElementById('arg-table').classList.add('active');
            }

            setTimeout(function() {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().draw();
            }, 50);
        }        
        
        // Auto-refresh 60 detik
        setInterval(function() { window.location.href = window.location.href.split('?')[0] + "?t=" + new Date().getTime(); }, 60000);
    </script>
</body>
</html>