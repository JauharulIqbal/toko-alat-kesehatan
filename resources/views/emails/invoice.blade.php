<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->nomor_invoice }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .order-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .order-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-info td {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .order-info td:first-child {
            font-weight: bold;
            color: #495057;
            width: 40%;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-sukses {
            background-color: #d1edff;
            color: #0c63e4;
        }

        .status-menunggu {
            background-color: #fff3cd;
            color: #856404;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        .total-row {
            background-color: #e7f3ff;
            font-weight: bold;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }

        .company-info {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $company['name'] }}</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Invoice Pembelian</p>
        </div>

        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $user->name }}</strong>,
            </div>

            <p>Terima kasih atas pembelian Anda! Berikut adalah invoice untuk pesanan Anda:</p>

            <div class="order-info">
                <table>
                    <tr>
                        <td>Nomor Invoice:</td>
                        <td><strong>{{ $invoice->nomor_invoice }}</strong></td>
                    </tr>
                    <tr>
                        <td>ID Pesanan:</td>
                        <td>{{ $pesanan->id_pesanan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Pesanan:</td>
                        <td>{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td>Status Pesanan:</td>
                        <td><span class="status-badge status-{{ $pesanan->status_pesanan }}">{{ strtoupper($pesanan->status_pesanan) }}</span></td>
                    </tr>
                    <tr>
                        <td>Total Pembayaran:</td>
                        <td><strong style="color: #0d6efd; font-size: 18px;">Rp {{ number_format($pesanan->total_harga_checkout, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <h3 style="color: #333; margin-bottom: 15px;">Detail Produk:</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->produk->nama_produk }}</strong><br>
                            <small style="color: #6c757d;">{{ $item->produk->toko->nama_toko }}</small>
                        </td>
                        <td style="text-align: center;">{{ $item->jumlah }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal_checkout, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Biaya Pengiriman ({{ $pesanan->jasaPengiriman->nama_jasa_pengiriman }})</strong></td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: right;"><strong>Rp {{ number_format($pesanan->jasaPengiriman->biaya_pengiriman, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="2"><strong>TOTAL PEMBAYARAN</strong></td>
                        <td style="text-align: right;"><strong>Rp {{ number_format($pesanan->total_harga_checkout, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('customer.pesanan.show', $pesanan->id_pesanan) }}" class="button">
                    Lihat Detail Pesanan
                </a>
            </div>

            <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; border-left: 4px solid #0d6efd;">
                <h4 style="margin-top: 0; color: #0d6efd;">Informasi Pengiriman:</h4>
                <p style="margin-bottom: 0;"><strong>Alamat:</strong> {{ $pesanan->alamat_pengiriman }}</p>
                @if($pesanan->catatan)
                <p style="margin-bottom: 0;"><strong>Catatan:</strong> {{ $pesanan->catatan }}</p>
                @endif
            </div>

            <p style="margin-top: 30px;">
                Invoice lengkap dalam format PDF terlampir dalam email ini.
                Anda juga dapat mengunduhnya kapan saja melalui halaman detail pesanan.
            </p>

            <p>
                Jika Anda memiliki pertanyaan mengenai pesanan ini, jangan ragu untuk menghubungi customer service kami di
                <a href="mailto:{{ $company['email'] }}" style="color: #0d6efd;">{{ $company['email'] }}</a>
                atau melalui telepon <strong>{{ $company['phone'] }}</strong>.
            </p>
        </div>

        <div class="footer">
            <p><strong>{{ $company['name'] }}</strong></p>
            <p>{{ $company['address'] }}</p>
            <p>Telepon: {{ $company['phone'] }} | Email: {{ $company['email'] }}</p>
            <p>Website: <a href="https://{{ $company['website'] }}" style="color: #0d6efd;">{{ $company['website'] }}</a></p>

            <hr style="margin: 20px 0; border: none; border-top: 1px solid #dee2e6;">
            <p style="font-size: 12px; color: #adb5bd;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>

</html>