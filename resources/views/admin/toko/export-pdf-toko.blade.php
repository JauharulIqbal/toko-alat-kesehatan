<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Toko - {{ date('d M Y') }}</title>
    
    <style>
        @page {
            margin: 30px 40px;
            size: A4 landscape;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 15px;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 20px;
            color: #0066cc;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 15px;
            color: #666;
            margin-bottom: 8px;
        }

        .header .info {
            font-size: 10px;
            color: #888;
        }

        /* Statistics */
        .statistics {
            width: 100%;
            margin-bottom: 20px;
            background: #f8f9fa;
            border-collapse: collapse;
            border-radius: 6px;
            overflow: hidden;
        }

        .statistics td {
            width: 25%;
            padding: 12px;
            text-align: center;
            border: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #0066cc;
            display: block;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Filter Info */
        .filter-info {
            background: #e6f3ff;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-left: 4px solid #0066cc;
            font-size: 10px;
            border-radius: 0 4px 4px 0;
        }

        .filter-info h4 {
            margin-bottom: 6px;
            color: #0066cc;
            font-size: 11px;
            font-weight: bold;
        }

        /* Main Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-table th,
        .main-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .main-table th {
            background-color: #0066cc;
            color: white;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            text-align: center;
        }

        .main-table td {
            font-size: 9px;
        }

        /* Column widths */
        .col-no { width: 5%; }
        .col-nama { width: 23%; }
        .col-pemilik { width: 17%; }
        .col-kota { width: 14%; }
        .col-alamat { width: 28%; }
        .col-status { width: 13%; }

        /* Table content styling */
        .fw-bold {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 2px;
        }

        .small {
            font-size: 8px;
            color: #666;
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        /* Status badges */
        .status {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            width: 100%;
        }

        .status.disetujui {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status.ditolak {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status.menunggu {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Striped rows */
        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Summary section */
        .summary-section {
            margin-top: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .summary-section h4 {
            margin-bottom: 10px;
            color: #333;
            font-size: 11px;
            font-weight: bold;
        }

        .summary-stats {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-stats td {
            width: 33.33%;
            padding: 8px;
            text-align: center;
            font-size: 9px;
        }

        .summary-stats .status {
            width: auto;
            display: inline-block;
            margin-bottom: 3px;
        }

        /* City distribution */
        .city-distribution {
            margin-top: 15px;
            background: #f0f8ff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #cce7ff;
        }

        .city-item {
            display: inline-block;
            margin: 3px 5px;
            padding: 4px 8px;
            background: white;
            border-radius: 4px;
            font-size: 9px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            font-size: 9px;
            color: #666;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-left {
            width: 60%;
            vertical-align: top;
            padding-right: 30px;
        }

        .footer-right {
            width: 40%;
            text-align: right;
            vertical-align: top;
        }

        .signature-area {
            margin-top: 35px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 6px;
            width: 140px;
            margin-left: auto;
            text-align: center;
            font-size: 10px;
        }

        /* No data message */
        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .no-data h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        /* Page info */
        .page-info {
            margin-top: 20px;
            text-align: center;
            padding-top: 12px;
            border-top: 1px solid #e9ecef;
            font-size: 8px;
            color: #999;
        }

        /* Content wrapper for better spacing */
        .content-wrapper {
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            {{-- Header --}}
            <div class="header">
                <h1>LAPORAN DATA TOKO</h1>
                <h2>SISTEM MANAJEMEN TOKO ALAT KESEHATAN</h2>
                <div class="info">
                    <div>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</div>
                    <div>Total Data: {{ $toko->count() }} Toko</div>
                    @if(request()->has('search') || request()->has('status') || request()->has('kota'))
                        <div style="color: #cc0000; font-weight: bold;">* Laporan dengan Filter</div>
                    @endif
                </div>
            </div>

            {{-- Statistics --}}
            <table class="statistics">
                <tr>
                    <td>
                        <span class="stat-number">{{ $toko->where('status_toko', 'disetujui')->count() }}</span>
                        <span class="stat-label">Disetujui</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $toko->where('status_toko', 'menunggu')->count() }}</span>
                        <span class="stat-label">Menunggu</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $toko->where('status_toko', 'ditolak')->count() }}</span>
                        <span class="stat-label">Ditolak</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $toko->count() }}</span>
                        <span class="stat-label">Total Toko</span>
                    </td>
                </tr>
            </table>

            {{-- Filter Information --}}
            @if(request()->has('search') || request()->has('status') || request()->has('kota'))
                <div class="filter-info">
                    <h4>Filter yang Diterapkan:</h4>
                    @if(request()->has('search') && request('search'))
                        <div>• Pencarian: "{{ request('search') }}"</div>
                    @endif
                    @if(request()->has('status') && request('status'))
                        <div>• Status: {{ ucfirst(request('status')) }}</div>
                    @endif
                    @if(request()->has('kota') && request('kota'))
                        @php
                            $kotaName = \App\Models\Kota::find(request('kota'))->nama_kota ?? 'Tidak ditemukan';
                        @endphp
                        <div>• Kota: {{ $kotaName }}</div>
                    @endif
                </div>
            @endif

            {{-- Main Data Table --}}
            @if($toko->count() > 0)
                <table class="main-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="col-nama">Nama Toko</th>
                            <th class="col-pemilik">Pemilik</th>
                            <th class="col-kota">Kota</th>
                            <th class="col-alamat">Alamat</th>
                            <th class="col-status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($toko as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama_toko }}</div>
                                    @if($item->deskripsi_toko)
                                        <div class="small">{{ Str::limit($item->deskripsi_toko, 35) }}</div>
                                    @endif
                                </td>
                                <td>{{ $item->user ? $item->user->name : '-' }}</td>
                                <td>{{ $item->kota ? $item->kota->nama_kota : '-' }}</td>
                                <td>{{ $item->alamat_toko ? Str::limit($item->alamat_toko, 45) : '-' }}</td>
                                <td class="text-center">
                                    <span class="status {{ $item->status_toko }}">
                                        {{ ucfirst($item->status_toko) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Summary by Status --}}
                <div class="summary-section">
                    <h4>Ringkasan Berdasarkan Status:</h4>
                    <table class="summary-stats">
                        <tr>
                            <td>
                                <span class="status disetujui">{{ $toko->where('status_toko', 'disetujui')->count() }} Disetujui</span><br>
                                <small>({{ $toko->count() > 0 ? number_format(($toko->where('status_toko', 'disetujui')->count() / $toko->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                            <td>
                                <span class="status menunggu">{{ $toko->where('status_toko', 'menunggu')->count() }} Menunggu</span><br>
                                <small>({{ $toko->count() > 0 ? number_format(($toko->where('status_toko', 'menunggu')->count() / $toko->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                            <td>
                                <span class="status ditolak">{{ $toko->where('status_toko', 'ditolak')->count() }} Ditolak</span><br>
                                <small>({{ $toko->count() > 0 ? number_format(($toko->where('status_toko', 'ditolak')->count() / $toko->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- City Distribution --}}
                @php
                    $tokoByCities = $toko->groupBy(function($item) {
                        return $item->kota ? $item->kota->nama_kota : 'Tidak Diketahui';
                    });
                @endphp
                
                @if($tokoByCities->count() > 1)
                    <div class="city-distribution">
                        <h4 style="margin-bottom: 8px; color: #0066cc; font-size: 11px;">Distribusi Toko per Kota:</h4>
                        @foreach($tokoByCities as $kotaName => $tokoInCity)
                            <span class="city-item">
                                <strong>{{ $kotaName }}:</strong> {{ $tokoInCity->count() }} 
                                ({{ number_format(($tokoInCity->count() / $toko->count()) * 100, 1) }}%)
                            </span>
                        @endforeach
                    </div>
                @endif

            @else
                <div class="no-data">
                    <h3>Tidak Ada Data</h3>
                    <p>Tidak ditemukan data toko yang sesuai dengan filter yang diterapkan.</p>
                </div>
            @endif

            {{-- Footer --}}
            <div class="footer">
                <table class="footer-table">
                    <tr>
                        <td class="footer-left">
                            <div><strong>Sistem Manajemen Toko Alat Kesehatan</strong></div>
                            <div>Laporan dibuat secara otomatis oleh sistem</div>
                            <div style="margin-top: 6px; color: #888;">
                                Dokumen ini bersifat rahasia dan hanya untuk keperluan internal
                            </div>
                        </td>
                        <td class="footer-right">
                            <div class="signature-area">
                                <div>{{ date('d F Y') }}</div>
                                <div class="signature-line">Administrator</div>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <div class="page-info">
                    Halaman 1 dari 1 | Dicetak pada {{ date('d F Y H:i') }} WIB | 
                    © {{ date('Y') }} Sistem Manajemen Toko Alat Kesehatan
                </div>
            </div>
        </div>
    </div>
</body>
</html>