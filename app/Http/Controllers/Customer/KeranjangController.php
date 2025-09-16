<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
    /**
     * Display shopping cart
     */
    public function index()
    {
        $keranjang = $this->getOrCreateCart();

        $items = ItemKeranjang::with(['produk.kategori', 'produk.toko'])
            ->where('id_keranjang', $keranjang->id_keranjang)
            ->get();

        $subtotal = $items->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        return view('customer.keranjang.index', compact('items', 'subtotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'quantity' => 'integer|min:1'
        ]);

        $produk = Produk::findOrFail($request->id_produk);
        $quantity = $request->quantity ?? 1;

        // Check if product has enough stock
        if ($produk->stok < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ]);
        }

        $keranjang = $this->getOrCreateCart();

        // Check if item already exists in cart
        $existingItem = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->jumlah + $quantity;

            if ($produk->stok < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok yang tersedia'
                ]);
            }

            $existingItem->jumlah = $newQuantity;
            $existingItem->save();
        } else {
            // Create new cart item
            ItemKeranjang::create([
                'id_item_keranjang' => Str::uuid(),
                'id_keranjang' => $keranjang->id_keranjang,
                'id_produk' => $request->id_produk,
                'nama_produk' => $produk->nama_produk,
                'jumlah' => $quantity,
                'harga' => $produk->harga
            ]);
        }

        // Update cart subtotal
        $this->updateCartSubtotal($keranjang);

        $cartCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = ItemKeranjang::findOrFail($itemId);
        $produk = $item->produk;

        // Check stock availability
        if ($produk->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ]);
        }

        $item->jumlah = $request->quantity;
        $item->save();

        // Update cart subtotal
        $keranjang = $item->keranjang;
        $this->updateCartSubtotal($keranjang);

        $itemSubtotal = $item->jumlah * $item->harga;

        return response()->json([
            'success' => true,
            'message' => 'Jumlah berhasil diperbarui',
            'item_subtotal' => number_format($itemSubtotal, 0, ',', '.'),
            'cart_subtotal' => number_format($keranjang->subtotal, 0, ',', '.')
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $item = ItemKeranjang::findOrFail($itemId);
        $keranjang = $item->keranjang;

        $item->delete();

        // Update cart subtotal
        $this->updateCartSubtotal($keranjang);

        $cartCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang',
            'cart_count' => $cartCount,
            'cart_subtotal' => number_format($keranjang->subtotal, 0, ',', '.')
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $keranjang = $this->getOrCreateCart();

        ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->delete();

        $keranjang->subtotal = 0;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    /**
     * Get cart count for navbar
     */
    public function getCount()
    {
        $keranjang = $this->getOrCreateCart();
        $count = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Get or create cart for current user
     */
    private function getOrCreateCart()
    {
        $user = Auth::user();

        $keranjang = Keranjang::where('id_user', $user->id_user)->first();

        if (!$keranjang) {
            $keranjang = Keranjang::create([
                'id_keranjang' => Str::uuid(),
                'id_user' => $user->id_user,
                'subtotal' => 0
            ]);
        }

        return $keranjang;
    }

    /**
     * Update cart subtotal
     */
    private function updateCartSubtotal($keranjang)
    {
        $subtotal = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)
            ->sum(DB::raw('jumlah * harga'));

        $keranjang->subtotal = $subtotal;
        $keranjang->save();

        return $subtotal;
    }
}
