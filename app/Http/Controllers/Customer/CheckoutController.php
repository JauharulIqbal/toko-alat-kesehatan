<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\JasaPengiriman;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $user = Auth::user();
        $keranjang = Keranjang::where('id_user', $user->id_user)->first();

        if (!$keranjang) {
            return redirect()->route('customer.keranjang.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $items = ItemKeranjang::with(['produk.toko'])
            ->where('id_keranjang', $keranjang->id_keranjang)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('customer.keranjang.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        // Calculate totals
        $subtotal = $items->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        // Get shipping services
        $jasaPengiriman = JasaPengiriman::orderBy('nama_jasa_pengiriman', 'asc')->get();

        // Get payment methods
        $metodePembayaran = MetodePembayaran::orderBy('metode_pembayaran', 'asc')->get();

        return view('customer.checkout.index', compact(
            'items',
            'subtotal',
            'jasaPengiriman',
            'metodePembayaran'
        ));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'id_jasa_pengiriman' => 'required|exists:jasa_pengiriman,id_jasa_pengiriman',
            'id_metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'alamat_pengiriman' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $keranjang = Keranjang::where('id_user', $user->id_user)->first();

        if (!$keranjang) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang tidak ditemukan.'
            ]);
        }

        $items = ItemKeranjang::with('produk')
            ->where('id_keranjang', $keranjang->id_keranjang)
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong.'
            ]);
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = $items->sum(function ($item) {
                return $item->jumlah * $item->harga;
            });

            $jasaPengiriman = JasaPengiriman::findOrFail($validated['id_jasa_pengiriman']);
            $biayaPengiriman = $jasaPengiriman->biaya_pengiriman;
            $totalHarga = $subtotal + $biayaPengiriman;

            // Create order
            $pesanan = Pesanan::create([
                'id_pesanan' => Str::uuid(),
                'id_user' => $user->id_user,
                'id_jasa_pengiriman' => $validated['id_jasa_pengiriman'],
                'status_pesanan' => 'menunggu',
                'total_harga_checkout' => $totalHarga,
            ]);

            // Create order items
            foreach ($items as $item) {
                // Check stock availability
                if ($item->produk->stok < $item->jumlah) {
                    throw new \Exception("Stok produk {$item->nama_produk} tidak mencukupi.");
                }

                ItemPesanan::create([
                    'id_item_pesanan' => Str::uuid(),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item->id_produk,
                    'jumlah' => $item->jumlah,
                    'subtotal_checkout' => $item->jumlah * $item->harga,
                ]);

                // Update product stock
                $item->produk->decrement('stok', $item->jumlah);
            }

            // Create payment record
            $pembayaran = Pembayaran::create([
                'id_pembayaran' => Str::uuid(),
                'id_pesanan' => $pesanan->id_pesanan,
                'id_metode_pembayaran' => $validated['id_metode_pembayaran'],
                'status_pembayaran' => 'menunggu',
                'jumlah_pembayaran' => $totalHarga,
                'paid_at' => now(),
            ]);

            // Clear cart
            ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->delete();
            $keranjang->update(['subtotal' => 0]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'order_id' => $pesanan->id_pesanan,
                'redirect_url' => route('customer.checkout.success', $pesanan->id_pesanan)
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show checkout success page
     */
    public function success($orderId)
    {
        $pesanan = Pesanan::with(['jasaPengiriman', 'pembayaran.metodePembayaran', 'items.produk'])
            ->where('id_user', Auth::id())
            ->findOrFail($orderId);

        return view('customer.checkout.success', compact('pesanan'));
    }
}