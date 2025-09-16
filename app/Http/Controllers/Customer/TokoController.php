<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kota;

class TokoController extends Controller
{
    /**
     * Display all approved stores
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $cityId = $request->get('city');
        $search = $request->get('search');
        
        $storesQuery = Toko::with(['kota', 'user'])
            ->withCount('produk')
            ->where('status_toko', 'disetujui');

        // Search by store name
        if ($search) {
            $storesQuery->where('nama_toko', 'like', "%{$search}%")
                        ->orWhere('deskripsi_toko', 'like', "%{$search}%");
        }

        // Filter by city
        if ($cityId) {
            $storesQuery->where('id_kota', $cityId);
        }

        // Apply sorting
        switch ($sort) {
            case 'name':
                $storesQuery->orderBy('nama_toko', 'asc');
                break;
            case 'products':
                $storesQuery->orderBy('produk_count', 'desc');
                break;
            case 'oldest':
                $storesQuery->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $storesQuery->orderBy('created_at', 'desc');
                break;
        }

        $stores = $storesQuery->paginate(20);

        // Get all cities with store count
        $cities = Kota::withCount(['toko' => function($query) {
            $query->where('status_toko', 'disetujui');
        }])->orderBy('nama_kota', 'asc')->get();

        $selectedCity = $cityId ? Kota::find($cityId) : null;

        return view('customer.toko.index', compact(
            'stores', 
            'cities',
            'selectedCity',
            'sort',
            'search'
        ));
    }

    /**
     * Display single store with its products
     */
    public function show(Request $request, $id)
    {
        $toko = Toko::with(['kota', 'user'])
            ->withCount('produk')
            ->where('status_toko', 'disetujui')
            ->findOrFail($id);

        $sort = $request->get('sort', 'newest');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        // Get store products
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('id_toko', $id)
            ->where('stok', '>=', 0);

        // Filter by category
        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
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

        $products = $productsQuery->paginate(20);

        // Get categories available in this store
        $categories = \App\Models\Kategori::whereHas('produk', function($query) use ($id) {
            $query->where('id_toko', $id)
                  ->where('stok', '>', 0);
        })->withCount(['produk' => function($query) use ($id) {
            $query->where('id_toko', $id)
                  ->where('stok', '>', 0);
        }])->orderBy('nama_kategori', 'asc')->get();

        // Get store statistics
        $stats = [
            'total_products' => $toko->produk_count,
            'available_products' => Produk::where('id_toko', $id)->where('stok', '>', 0)->count(),
            'categories_count' => $categories->count(),
            'avg_price' => Produk::where('id_toko', $id)->avg('harga')
        ];

        $selectedCategory = $categoryId ? \App\Models\Kategori::find($categoryId) : null;

        return view('customer.toko.show', compact(
            'toko', 
            'products', 
            'categories',
            'stats',
            'selectedCategory',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Get store products by AJAX for filtering
     */
    public function getProducts(Request $request, $id)
    {
        $sort = $request->get('sort', 'newest');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('id_toko', $id)
            ->where('stok', '>=', 0);

        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
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

        $products = $productsQuery->limit(20)->get();

        return response()->json([
            'success' => true,
            'products' => view('customer.partials.product-grid', compact('products'))->render(),
            'count' => $products->count()
        ]);
    }

    /**
     * Get stores by AJAX for filtering
     */
    public function filter(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $cityId = $request->get('city');
        $search = $request->get('search');
        
        $storesQuery = Toko::with(['kota', 'user'])
            ->withCount('produk')
            ->where('status_toko', 'disetujui');

        if ($search) {
            $storesQuery->where('nama_toko', 'like', "%{$search}%")
                        ->orWhere('deskripsi_toko', 'like', "%{$search}%");
        }

        if ($cityId) {
            $storesQuery->where('id_kota', $cityId);
        }

        switch ($sort) {
            case 'name':
                $storesQuery->orderBy('nama_toko', 'asc');
                break;
            case 'products':
                $storesQuery->orderBy('produk_count', 'desc');
                break;
            case 'oldest':
                $storesQuery->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $storesQuery->orderBy('created_at', 'desc');
                break;
        }

        $stores = $storesQuery->limit(20)->get();

        return response()->json([
            'success' => true,
            'stores' => view('customer.partials.store-grid', compact('stores'))->render(),
            'count' => $stores->count()
        ]);
    }
}