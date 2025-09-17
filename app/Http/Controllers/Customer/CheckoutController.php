<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\JasaPengiriman;
use App\Models\Invoice;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\NomorRekeningPengguna;
use App\Services\InvoiceService;
use App\Mail\InvoiceMail;

class CheckoutController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

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

        // Get payment methods with user's saved account numbers
        $metodePembayaran = MetodePembayaran::with(['nomorRekeningPengguna' => function($query) use ($user) {
            $query->where('id_user', $user->id_user);
        }])->orderBy('metode_pembayaran', 'asc')->get();

        // Check if user has required payment methods for prepaid
        $hasRequiredPaymentMethods = true;
        $missingPaymentMethods = [];

        foreach ($metodePembayaran as $metode) {
            if ($metode->tipe_pembayaran === 'prepaid' && $metode->nomorRekeningPengguna->isEmpty()) {
                $hasRequiredPaymentMethods = false;
                $missingPaymentMethods[] = $metode->metode_pembayaran;
            }
        }

        return view('customer.checkout.index', compact(
            'items',
            'subtotal',
            'jasaPengiriman',
            'metodePembayaran',
            'hasRequiredPaymentMethods',
            'missingPaymentMethods'
        ));
    }

    /**
     * Get user payment methods for selected payment method
     */
    public function getPaymentMethods($metodeId)
    {
        $user = Auth::user();
        $metode = MetodePembayaran::findOrFail($metodeId);
        
        if ($metode->tipe_pembayaran === 'postpaid') {
            // For COD/postpaid, no account number needed
            return response()->json([
                'success' => true,
                'type' => 'postpaid',
                'accounts' => []
            ]);
        }

        $accounts = NomorRekeningPengguna::where('id_user', $user->id_user)
            ->where('id_metode_pembayaran', $metodeId)
            ->get();

        return response()->json([
            'success' => true,
            'type' => 'prepaid',
            'accounts' => $accounts
        ]);
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $rules = [
            'id_jasa_pengiriman' => 'required|exists:jasa_pengiriman,id_jasa_pengiriman',
            'id_metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'alamat_pengiriman' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:500'
        ];

        // Check payment method type
        $metodePembayaran = MetodePembayaran::findOrFail($request->id_metode_pembayaran);
        
        if ($metodePembayaran->tipe_pembayaran === 'prepaid') {
            $rules['id_nrp'] = 'required|exists:nomor_rekening_pengguna,id_nrp';
        } else {
            $rules['nomor_rekening_input'] = 'required|string|max:50';
        }

        $validated = $request->validate($rules);
        $user = Auth::user();
        
        // For prepaid, verify that the selected nomor rekening belongs to current user
        if ($metodePembayaran->tipe_pembayaran === 'prepaid') {
            $nomorRekening = NomorRekeningPengguna::where('id_nrp', $validated['id_nrp'])
                ->where('id_user', $user->id_user)
                ->first();
                
            if (!$nomorRekening) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor rekening tidak valid.'
                ]);
            }
        }

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
                'status_pesanan' => 'sukses', // Auto set to sukses for auto invoice
                'total_harga_checkout' => $totalHarga,
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'catatan' => $validated['catatan']
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
            $paymentData = [
                'id_pembayaran' => Str::uuid(),
                'id_pesanan' => $pesanan->id_pesanan,
                'id_metode_pembayaran' => $validated['id_metode_pembayaran'],
                'status_pembayaran' => 'sukses', // Auto set to sukses for auto invoice
                'jumlah_pembayaran' => $totalHarga,
                'paid_at' => now(),
            ];

            if ($metodePembayaran->tipe_pembayaran === 'prepaid') {
                $paymentData['id_nrp'] = $validated['id_nrp'];
            } else {
                // For COD/postpaid, create temporary account number record
                $tempAccount = NomorRekeningPengguna::create([
                    'id_nrp' => Str::uuid(),
                    'nomor_rekening' => $validated['nomor_rekening_input'],
                    'id_user' => $user->id_user,
                    'id_metode_pembayaran' => $validated['id_metode_pembayaran']
                ]);
                $paymentData['id_nrp'] = $tempAccount->id_nrp;
            }

            $pembayaran = Pembayaran::create($paymentData);

            // Generate invoice - Always generate for successful orders
            $invoice = $this->invoiceService->generateInvoice($pesanan);

            // Send email with invoice attachment
            $this->sendInvoiceEmail($user, $invoice, $pesanan);

            // Clear cart
            ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->delete();
            $keranjang->update(['subtotal' => 0]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat dan invoice telah dikirim ke email Anda.',
                'order_id' => $pesanan->id_pesanan,
                'invoice_id' => $invoice->id_invoice,
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
        $pesanan = Pesanan::with(['jasaPengiriman', 'pembayaran.metodePembayaran', 'pembayaran.nomorRekeningPengguna', 'items.produk', 'invoice'])
            ->where('id_user', Auth::id())
            ->findOrFail($orderId);

        return view('customer.checkout.success', compact('pesanan'));
    }

    /**
     * Download invoice
     */
    public function downloadInvoice($invoiceId)
    {
        $invoice = Invoice::with('pesanan')
            ->whereHas('pesanan', function($query) {
                $query->where('id_user', Auth::id());
            })
            ->findOrFail($invoiceId);

        return $this->invoiceService->downloadInvoice($invoiceId);
    }

    /**
     * Send invoice email
     */
    private function sendInvoiceEmail($user, $invoice, $pesanan)
    {
        try {
            Mail::to($user->email)->send(new InvoiceMail($invoice, $pesanan));
            
            // Update invoice status
            $invoice->update([
                'status_kirim' => 'berhasil',
                'dikirim_pada' => now()
            ]);
        } catch (\Exception $e) {
            // Update invoice status as failed
            $invoice->update([
                'status_kirim' => 'gagal',
                'dikirim_pada' => now()
            ]);
            
            Log::error('Failed to send invoice email: ' . $e->getMessage());
        }
    }
}