<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display all products with filtering
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $storeId = $request->get('store');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0);

        // Filter by category
        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
        }

        // Filter by store
        if ($storeId) {
            $productsQuery->where('id_toko', $storeId);
        }

        // Filter by price range
        if ($minPrice) {
            $productsQuery->where('harga', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('harga', '<=', $maxPrice);
        }

        // Apply sorting
        switch ($sort) {
            case 'price-low':
                $productsQuery->orderBy('harga', 'asc');
                break;
            case 'price-high':
                $productsQuery->orderBy('harga', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('nama_produk', 'asc');
                break;
            case 'stock':
                $productsQuery->orderBy('stok', 'desc');
                break;
            case 'oldest':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->paginate(24);

        // Get all categories with product count
        $categories = Kategori::withCount('produk')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // Get all stores with product count
        $stores = Toko::withCount('produk')
            ->where('status_toko', 'disetujui')
            ->orderBy('nama_toko', 'asc')
            ->get();

        $selectedCategory = $categoryId ? Kategori::find($categoryId) : null;
        $selectedStore = $storeId ? Toko::find($storeId) : null;

        return view('customer.produk.index', compact(
            'products', 
            'categories', 
            'stores',
            'selectedCategory',
            'selectedStore',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Display single product detail
     */
    public function show($id)
    {
        $produk = Produk::with(['kategori', 'toko.kota'])
            ->findOrFail($id);

        // Get related products from same category
        $relatedProducts = Produk::with(['kategori', 'toko'])
            ->where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $id)
            ->where('stok', '>', 0)
            ->limit(8)
            ->get();

        // Get other products from same store
        $storeProducts = Produk::with(['kategori', 'toko'])
            ->where('id_toko', $produk->id_toko)
            ->where('id_produk', '!=', $id)
            ->where('stok', '>', 0)
            ->limit(6)
            ->get();

        return view('customer.produk.show', compact(
            'produk', 
            'relatedProducts', 
            'storeProducts'
        ));
    }

    /**
     * Get product quick view data (for modal)
     */
    public function quickView($id)
    {
        $produk = Produk::with(['kategori', 'toko'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $produk->id_produk,
                'name' => $produk->nama_produk,
                'description' => $produk->deskripsi,
                'price' => $produk->harga,
                'formatted_price' => number_format($produk->harga, 0, ',', '.'),
                'stock' => $produk->stok,
                'image' => $produk->gambar_produk ? asset('storage/produk/' . $produk->gambar_produk) : 'https://via.placeholder.com/400x300',
                'category' => $produk->kategori->nama_kategori ?? 'Tidak ada kategori',
                'store' => $produk->toko->nama_toko ?? 'Tidak ada toko',
                'store_location' => $produk->toko->kota->nama_kota ?? ''
            ]
        ]);
    }

    /**
     * Get products by AJAX for filtering
     */
    public function filter(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $storeId = $request->get('store');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0);

        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
        }

        if ($storeId) {
            $productsQuery->where('id_toko', $storeId);
        }

        if ($minPrice) {
            $productsQuery->where('harga', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('harga', '<=', $maxPrice);
        }

        switch ($sort) {
            case 'price-low':
                $productsQuery->orderBy('harga', 'asc');
                break;
            case 'price-high':
                $productsQuery->orderBy('harga', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('nama_produk', 'asc');
                break;
            case 'stock':
                $productsQuery->orderBy('stok', 'desc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->limit(24)->get();

        return response()->json([
            'success' => true,
            'products' => view('customer.partials.product-grid', compact('products'))->render(),
            'count' => $products->count()
        ]);
    }
}