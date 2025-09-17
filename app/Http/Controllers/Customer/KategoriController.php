<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;

class KategoriController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Kategori::withCount(['produk' => function($query) {
            $query->where('stok', '>', 0);
        }])->orderBy('nama_kategori', 'asc')->paginate(20);

        return view('customer.kategori.index', compact('categories'));
    }

    /**
     * Show products in specific category
     */
    public function show(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        
        $sort = $request->get('sort', 'newest');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $storeId = $request->get('store');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('id_kategori', $id)
            ->where('stok', '>=', 0);

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

        // Get stores that have products in this category
        $stores = \App\Models\Toko::whereHas('produk', function($query) use ($id) {
            $query->where('id_kategori', $id)
                  ->where('stok', '>', 0);
        })->withCount(['produk' => function($query) use ($id) {
            $query->where('id_kategori', $id)
                  ->where('stok', '>', 0);
        }])->where('status_toko', 'disetujui')
        ->orderBy('nama_toko', 'asc')->get();

        $selectedStore = $storeId ? \App\Models\Toko::find($storeId) : null;

        return view('customer.kategori.show', compact(
            'kategori', 
            'products', 
            'stores',
            'selectedStore',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Get category products via AJAX
     */
    public function products(Request $request)
    {
        $categoryId = $request->get('category');
        $sort = $request->get('sort', 'newest');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0);

        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
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
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->limit(12)->get();

        return response()->json([
            'success' => true,
            'products' => view('customer.partials.product-grid', compact('products'))->render()
        ]);
    }
}