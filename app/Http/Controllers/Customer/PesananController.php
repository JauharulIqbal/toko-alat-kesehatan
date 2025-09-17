<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class PesananController extends Controller
{
    /**
     * Display user's orders
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Pesanan::with(['jasaPengiriman', 'pembayaran.metodePembayaran', 'items.produk'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status_pesanan', $status);
        }

        $pesanan = $query->paginate(10);

        // Get order status counts
        $statusCounts = [
            'semua' => Pesanan::where('id_user', Auth::id())->count(),
            'menunggu' => Pesanan::where('id_user', Auth::id())->where('status_pesanan', 'menunggu')->count(),
            'dikirim' => Pesanan::where('id_user', Auth::id())->where('status_pesanan', 'dikirim')->count(),
            'sukses' => Pesanan::where('id_user', Auth::id())->where('status_pesanan', 'sukses')->count(),
            'gagal' => Pesanan::where('id_user', Auth::id())->where('status_pesanan', 'gagal')->count(),
        ];

        return view('customer.pesanan.index', compact('pesanan', 'statusCounts', 'status'));
    }

    /**
     * Show single order detail
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['jasaPengiriman', 'pembayaran.metodePembayaran', 'items.produk.toko'])
            ->where('id_user', Auth::id())
            ->findOrFail($id);

        return view('customer.pesanan.show', compact('pesanan'));
    }

    /**
     * Cancel order
     */
    public function cancel($id)
    {
        $pesanan = Pesanan::where('id_user', Auth::id())->findOrFail($id);

        if ($pesanan->status_pesanan !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat dibatalkan.'
            ]);
        }

        $pesanan->update(['status_pesanan' => 'gagal']);

        // Update payment status
        if ($pesanan->pembayaran) {
            $pesanan->pembayaran->update(['status_pembayaran' => 'gagal']);
        }

        // Restore product stock
        foreach ($pesanan->items as $item) {
            $item->produk->increment('stok', $item->jumlah);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibatalkan.'
        ]);
    }

    /**
     * Confirm order received
     */
    public function confirm($id)
    {
        $pesanan = Pesanan::where('id_user', Auth::id())->findOrFail($id);

        if ($pesanan->status_pesanan !== 'dikirim') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum dikirim atau sudah selesai.'
            ]);
        }

        $pesanan->update(['status_pesanan' => 'sukses']);

        // Update payment status
        if ($pesanan->pembayaran) {
            $pesanan->pembayaran->update(['status_pembayaran' => 'sukses']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan dikonfirmasi telah diterima.'
        ]);
    }
}
