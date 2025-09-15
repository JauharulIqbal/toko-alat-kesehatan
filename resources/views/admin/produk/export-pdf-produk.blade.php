<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Produk - {{ date('d M Y') }}</title>
    
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
            font-size: 10px;
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
            font-size: 9px;
            text-transform: uppercase;
            text-align: center;
        }

        .main-table td {
            font-size: 9px;
        }

        /* Column widths */
        .col-no { width: 4%; }
        .col-nama { width: 18%; }
        .col-kategori { width: 12%; }
        .col-toko { width: 15%; }
        .col-harga { width: 12%; }
        .col-stok { width: 8%; }
        .col-status { width: 10%; }
        .col-deskripsi { width: 21%; }

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

        .text-right {
            text-align: right;
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

        .status.tersedia {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status.menipis {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status.habis {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

        /* Category & Store distribution */
        .distribution-section {
            margin-top: 15px;
            background: #f0f8ff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #cce7ff;
        }

        .distribution-item {
            display: inline-block;
            margin: 3px 5px;
            padding: 4px 8px;
            background: white;
            border-radius: 4px;
            font-size: 9px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        /* Value summary */
        .value-section {
            margin-top: 15px;
            background: #fff5f5;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #fed7d7;
        }

        .value-item {
            display: inline-block;
            margin: 3px 8px;
            padding: 6px 10px;
            background: white;
            border-radius: 4px;
            font-size: 9px;
            border: 1px solid #ddd;
            text-align: center;
            min-width: 100px;
        }

        .value-number {
            font-weight: bold;
            color: #d53f8c;
            display: block;
            font-size: 12px;
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

        /* Price formatting */
        .price {
            font-weight: bold;
            color: #0066cc;
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
                <h1>LAPORAN DATA PRODUK</h1>
                <h2>SISTEM MANAJEMEN TOKO ALAT KESEHATAN</h2>
                <div class="info">
                    <div>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</div>
                    <div>Total Data: {{ $produk->count() }} Produk</div>
                    @if(request()->has('search') || request()->has('kategori') || request()->has('toko') || request()->has('stok'))
                        <div style="color: #cc0000; font-weight: bold;">* Laporan dengan Filter</div>
                    @endif
                </div>
            </div>

            {{-- Statistics --}}
            @php
                $stokTersedia = $produk->where('stok', '>', 10)->count();
                $stokMenupis = $produk->where('stok', '>', 0)->where('stok', '<=', 10)->count();
                $stokHabis = $produk->where('stok', 0)->count();
                $totalNilaiStok = $produk->sum(function($item) { return $item->harga * $item->stok; });
            @endphp
            <table class="statistics">
                <tr>
                    <td>
                        <span class="stat-number">{{ $stokTersedia }}</span>
                        <span class="stat-label">Tersedia</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $stokMenupis }}</span>
                        <span class="stat-label">Menipis</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $stokHabis }}</span>
                        <span class="stat-label">Habis</span>
                    </td>
                    <td>
                        <span class="stat-number">{{ $produk->count() }}</span>
                        <span class="stat-label">Total Produk</span>
                    </td>
                </tr>
            </table>

            {{-- Filter Information --}}
            @if(request()->has('search') || request()->has('kategori') || request()->has('toko') || request()->has('stok'))
                <div class="filter-info">
                    <h4>Filter yang Diterapkan:</h4>
                    @if(request()->has('search') && request('search'))
                        <div>• Pencarian: "{{ request('search') }}"</div>
                    @endif
                    @if(request()->has('kategori') && request('kategori'))
                        @php
                            $kategoriName = \App\Models\Kategori::find(request('kategori'))->nama_kategori ?? 'Tidak ditemukan';
                        @endphp
                        <div>• Kategori: {{ $kategoriName }}</div>
                    @endif
                    @if(request()->has('toko') && request('toko'))
                        @php
                            $tokoName = \App\Models\Toko::find(request('toko'))->nama_toko ?? 'Tidak ditemukan';
                        @endphp
                        <div>• Toko: {{ $tokoName }}</div>
                    @endif
                    @if(request()->has('stok') && request('stok'))
                        <div>• Status Stok: {{ ucfirst(request('stok')) }}</div>
                    @endif
                </div>
            @endif

            {{-- Main Data Table --}}
            @if($produk->count() > 0)
                <table class="main-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="col-nama">Nama Produk</th>
                            <th class="col-kategori">Kategori</th>
                            <th class="col-toko">Toko</th>
                            <th class="col-harga">Harga</th>
                            <th class="col-stok">Stok</th>
                            <th class="col-status">Status</th>
                            <th class="col-deskripsi">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $index => $item)
                            @php
                                $statusClass = $item->stok == 0 ? 'habis' : ($item->stok <= 10 ? 'menipis' : 'tersedia');
                                $statusText = $item->stok == 0 ? 'Habis' : ($item->stok <= 10 ? 'Menipis' : 'Tersedia');
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama_produk }}</div>
                                    <div class="small">ID: {{ $item->id_produk }}</div>
                                </td>
                                <td>{{ $item->kategori ? $item->kategori->nama_kategori : '-' }}</td>
                                <td>{{ $item->toko ? Str::limit($item->toko->nama_toko, 20) : '-' }}</td>
                                <td class="text-right">
                                    <span class="price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">{{ number_format($item->stok) }}</td>
                                <td class="text-center">
                                    <span class="status {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Summary by Status --}}
                <div class="summary-section">
                    <h4>Ringkasan Berdasarkan Status Stok:</h4>
                    <table class="summary-stats">
                        <tr>
                            <td>
                                <span class="status tersedia">{{ $stokTersedia }} Tersedia</span><br>
                                <small>({{ $produk->count() > 0 ? number_format(($stokTersedia / $produk->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                            <td>
                                <span class="status menipis">{{ $stokMenupis }} Menipis</span><br>
                                <small>({{ $produk->count() > 0 ? number_format(($stokMenupis / $produk->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                            <td>
                                <span class="status habis">{{ $stokHabis }} Habis</span><br>
                                <small>({{ $produk->count() > 0 ? number_format(($stokHabis / $produk->count()) * 100, 1) : 0 }}%)</small>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Category Distribution --}}
                @php
                    $produkByCategories = $produk->groupBy(function($item) {
                        return $item->kategori ? $item->kategori->nama_kategori : 'Tidak Berkategori';
                    });
                @endphp
                
                @if($produkByCategories->count() > 1)
                    <div class="distribution-section">
                        <h4 style="margin-bottom: 8px; color: #0066cc; font-size: 11px;">Distribusi Produk per Kategori:</h4>
                        @foreach($produkByCategories as $kategoriName => $produkInCategory)
                            <span class="distribution-item">
                                <strong>{{ $kategoriName }}:</strong> {{ $produkInCategory->count() }} 
                                ({{ number_format(($produkInCategory->count() / $produk->count()) * 100, 1) }}%)
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Store Distribution --}}
                @php
                    $produkByStores = $produk->groupBy(function($item) {
                        return $item->toko ? $item->toko->nama_toko : 'Tanpa Toko';
                    });
                @endphp
                
                @if($produkByStores->count() > 1)
                    <div class="distribution-section" style="background: #f0fff4; border-color: #c6f6d5;">
                        <h4 style="margin-bottom: 8px; color: #38a169; font-size: 11px;">Distribusi Produk per Toko:</h4>
                        @foreach($produkByStores as $tokoName => $produkInStore)
                            <span class="distribution-item">
                                <strong>{{ Str::limit($tokoName, 25) }}:</strong> {{ $produkInStore->count() }} 
                                ({{ number_format(($produkInStore->count() / $produk->count()) * 100, 1) }}%)
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Value Summary --}}
                <div class="value-section">
                    <h4 style="margin-bottom: 8px; color: #d53f8c; font-size: 11px;">Ringkasan Nilai:</h4>
                    <span class="value-item">
                        <span class="value-number">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</span>
                        <span>Total Nilai Stok</span>
                    </span>
                    <span class="value-item">
                        <span class="value-number">Rp {{ $produk->count() > 0 ? number_format($produk->avg('harga'), 0, ',', '.') : 0 }}</span>
                        <span>Harga Rata-rata</span>
                    </span>
                    <span class="value-item">
                        <span class="value-number">{{ $produk->count() > 0 ? number_format($produk->avg('stok'), 0, ',', '.') : 0 }}</span>
                        <span>Stok Rata-rata</span>
                    </span>
                    <span class="value-item">
                        <span class="value-number">Rp {{ $produk->count() > 0 ? number_format($produk->max('harga'), 0, ',', '.') : 0 }}</span>
                        <span>Harga Tertinggi</span>
                    </span>
                    <span class="value-item">
                        <span class="value-number">Rp {{ $produk->count() > 0 ? number_format($produk->min('harga'), 0, ',', '.') : 0 }}</span>
                        <span>Harga Terendah</span>
                    </span>
                </div>

            @else
                <div class="no-data">
                    <h3>Tidak Ada Data</h3>
                    <p>Tidak ditemukan data produk yang sesuai dengan filter yang diterapkan.</p>
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