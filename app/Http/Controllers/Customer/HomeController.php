<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display customer home page with products and categories
     */
    public function index()
    {
        // Get featured/popular products (limit 12 for home display)
        $featuredProducts = Produk::with(['kategori', 'toko'])
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        // Get all categories for filter with product count
        $categories = Kategori::withCount('produk')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // Get recent products (last 8 products added)
        $recentProducts = Produk::with(['kategori', 'toko'])
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->skip(12) // Skip the featured products
            ->limit(8)
            ->get();

        // Get popular stores based on product count
        $popularStores = Toko::withCount('produk')
            ->orderBy('produk_count', 'desc')
            ->limit(6)
            ->get();

        // Banner/promotion data (you can create a model for this later)
        $banners = [
            [
                'title' => 'Alat Kesehatan Terlengkap',
                'subtitle' => 'Dapatkan alat kesehatan berkualitas dengan harga terbaik',
                'image' => 'banner-1.jpg',
                'link' => route('customer.produk.index')
            ],
            [
                'title' => 'Free Ongkir Se-Indonesia',
                'subtitle' => 'Untuk pembelian minimal Rp 100.000',
                'image' => 'banner-2.jpg',
                'link' => '#'
            ]
        ];

        return view('customer.home', compact([
            'featuredProducts',
            'categories', 
            'recentProducts',
            'popularStores',
            'banners'
        ]));
    }

    /**
     * Search products with advanced filtering
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category');
        $sort = $request->get('sort', 'newest');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0);

        // Search by name or description
        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('nama_produk', 'like', "%{$query}%")
                  ->orWhere('deskripsi', 'like', "%{$query}%");
            });
        }

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
            case 'oldest':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->paginate(20);

        // Get categories with product count
        $categories = Kategori::withCount('produk')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('customer.search', compact('products', 'categories', 'query', 'categoryId'));
    }

    /**
     * Get products by category (AJAX and regular)
     */
    public function getByCategory(Request $request, $categoryId = null)
    {
        $sort = $request->get('sort', 'newest');
        
        $productsQuery = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0);

        if ($categoryId) {
            $productsQuery->where('id_kategori', $categoryId);
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
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->paginate(20);

        $categories = Kategori::withCount('produk')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $selectedCategory = $categoryId ? Kategori::find($categoryId) : null;

        if ($request->ajax()) {
            return response()->json([
                'products' => view('customer.partials.product-grid', compact('products'))->render(),
                'pagination' => $products->links()->toHtml()
            ]);
        }

        return view('customer.category', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Get category products for AJAX filtering
     */
    public function getCategoryProducts(Request $request)
    {
        $categoryId = $request->get('category');
        
        $products = Produk::with(['kategori', 'toko'])
            ->where('stok', '>=', 0)
            ->when($categoryId, function ($q) use ($categoryId) {
                return $q->where('id_kategori', $categoryId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        return response()->json([
            'success' => true,
            'products' => view('customer.partials.product-grid', compact('products'))->render()
        ]);
    }

    /**
     * Get popular products for home page
     */
    public function getPopularProducts()
    {
        // You can implement this based on views, purchases, or ratings
        // For now, we'll use products with high stock as "popular"
        $popularProducts = Produk::with(['kategori', 'toko'])
            ->where('stok', '>', 10)
            ->orderBy('stok', 'desc')
            ->limit(8)
            ->get();

        return $popularProducts;
    }

    /**
     * Get products on sale/discount
     */
    public function getSaleProducts()
    {
        // This would require a discount/sale price field in your products table
        // For now, return random products as placeholder
        $saleProducts = Produk::with(['kategori', 'toko'])
            ->where('stok', '>', 0)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return $saleProducts;
    }

    /**
     * Get product statistics for dashboard
     */
    public function getProductStats()
    {
        $stats = [
            'total_products' => Produk::count(),
            'available_products' => Produk::where('stok', '>', 0)->count(),
            'out_of_stock' => Produk::where('stok', '=', 0)->count(),
            'total_categories' => Kategori::count(),
            'total_stores' => Toko::where('status_toko', 'disetujui')->count(),
        ];

        return $stats;
    }
}