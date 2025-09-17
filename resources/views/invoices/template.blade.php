<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->nomor_invoice }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info {
            float: left;
            width: 60%;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        .invoice-info {
            float: right;
            width: 35%;
            text-align: right;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .customer-info {
            margin: 30px 0;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .customer-title {
            font-weight: bold;
            font-size: 14px;
            color: #0d6efd;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }

        .order-details {
            width: 100%;
            margin: 30px 0;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-details th,
        .order-details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .order-details th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }

        .order-details tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            float: right;
            width: 300px;
            margin-top: 20px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .summary .total-row {
            font-weight: bold;
            font-size: 14px;
            background-color: #0d6efd;
            color: white;
        }

        .payment-info {
            margin-top: 40px;
            clear: both;
        }

        .payment-info table {
            width: 100%;
            border-collapse: collapse;
            background: #f8f9fa;
            border-radius: 5px;
            overflow: hidden;
        }

        .payment-info th,
        .payment-info td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .payment-info th {
            background-color: #198754;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            color: #6c757d;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-menunggu {
            background-color: #ffc107;
            color: #000;
        }

        .status-sukses {
            background-color: #198754;
            color: #fff;
        }

        .status-dibatalkan {
            background-color: #dc3545;
            color: #fff;
        }

        .status-dikirim {
            background-color: #0dcaf0;
            color: #000;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header clearfix">
        <div class="company-info">
            <div class="company-name">{{ $company['name'] }}</div>
            <div>{{ $company['address'] }}</div>
            <div>Telepon: {{ $company['phone'] }}</div>
            <div>Email: {{ $company['email'] }}</div>
            <div>Website: {{ $company['website'] }}</div>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">INVOICE</div>
            <div><strong>{{ $invoice->nomor_invoice }}</strong></div>
            <div>Tanggal: {{ $invoice->created_at->format('d/m/Y') }}</div>
            <div>Jatuh Tempo: {{ $invoice->created_at->addDays(7)->format('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="customer-info">
        <div class="customer-title">INFORMASI PELANGGAN</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <strong>Nama:</strong> {{ $pesanan->user->name }}<br>
                    <strong>Email:</strong> {{ $pesanan->user->email }}<br>
                    @if($pesanan->user->no_hp)
                    <strong>Telepon:</strong> {{ $pesanan->user->no_hp }}<br>
                    @endif
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Alamat Pengiriman:</strong><br>
                    {{ $pesanan->alamat_pengiriman }}
                    @if($pesanan->catatan)
                    <br><br><strong>Catatan:</strong><br>
                    {{ $pesanan->catatan }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Order Details -->
    <div class="order-details">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Toko</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->produk->nama_produk }}</strong>
                        @if($item->produk->deskripsi)
                        <br><small style="color: #6c757d;">{{ Str::limit($item->produk->deskripsi, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $item->produk->toko->nama_toko }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal_checkout / $item->jumlah, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal_checkout, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Rp {{ number_format($pesanan->items->sum('subtotal_checkout'), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Pengiriman:</td>
                    <td class="text-right">Rp {{ number_format($pesanan->jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Jasa Pengiriman:</strong></td>
                    <td class="text-right"><strong>{{ $pesanan->jasaPengiriman->nama_jasa_pengiriman }}</strong></td>
                </tr>
                <tr class="total-row">
                    <td><strong>TOTAL:</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($pesanan->total_harga_checkout, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="payment-info">
        <table>
            <thead>
                <tr>
                    <th colspan="2">INFORMASI PEMBAYARAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>ID Pesanan:</strong></td>
                    <td>{{ $pesanan->id_pesanan }}</td>
                </tr>
                <tr>
                    <td><strong>Metode Pembayaran:</strong></td>
                    <td>{{ $pesanan->pembayaran->metodePembayaran->metode_pembayaran }}</td>
                </tr>
                @if($pesanan->pembayaran->nomorRekeningPengguna)
                <tr>
                    <td><strong>Nomor Rekening:</strong></td>
                    <td>{{ $pesanan->pembayaran->nomorRekeningPengguna->nomor_rekening }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Status Pesanan:</strong></td>
                    <td>
                        <span class="status-badge status-{{ $pesanan->status_pesanan }}">
                            {{ strtoupper($pesanan->status_pesanan) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Status Pembayaran:</strong></td>
                    <td>
                        <span class="status-badge status-{{ $pesanan->pembayaran->status_pembayaran }}">
                            {{ strtoupper($pesanan->pembayaran->status_pembayaran) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Pemesanan:</strong></td>
                    <td>{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</td>
                </tr>
                @if($pesanan->pembayaran->paid_at)
                <tr>
                    <td><strong>Tanggal Pembayaran:</strong></td>
                    <td>{{ $pesanan->pembayaran->paid_at->format('d F Y, H:i') }} WIB</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Terima kasih atas kepercayaan Anda berbelanja di {{ $company['name'] }}!</strong></p>
        <p>Invoice ini dibuat secara otomatis dan tidak memerlukan tanda tangan.</p>
        <p>Untuk pertanyaan terkait invoice ini, silakan hubungi customer service kami.</p>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #dee2e6;">
        <small>
            Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB | 
            {{ $company['name'] }} - {{ $company['website'] }}
        </small>
    </div>
</body>
</html>