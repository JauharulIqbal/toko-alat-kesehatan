<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemKeranjang extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'item_keranjang';
    protected $primaryKey = 'id_item_keranjang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_produk',
        'jumlah',
        'harga',
        'id_keranjang',
        'id_produk',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'harga' => 'decimal:2',
    ];

    /**
     * Get the cart that owns this item
     */
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    /**
     * Get the product details
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Get the subtotal for this item
     */
    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->harga;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Check if item quantity exceeds product stock
     */
    public function exceedsStock()
    {
        return $this->produk && $this->jumlah > $this->produk->stok;
    }

    /**
     * Get maximum quantity allowed (based on product stock)
     */
    public function getMaxQuantityAttribute()
    {
        return $this->produk ? $this->produk->stok : 0;
    }

    /**
     * Check if product is still available
     */
    public function isProductAvailable()
    {
        return $this->produk && $this->produk->stok > 0;
    }

    /**
     * Update quantity and recalculate cart subtotal
     */
    public function updateQuantity($newQuantity)
    {
        // Validate stock availability
        if ($this->produk && $newQuantity > $this->produk->stok) {
            throw new \Exception("Quantity exceeds available stock. Max: {$this->produk->stok}");
        }

        // Update quantity
        $this->update(['jumlah' => $newQuantity]);

        // Recalculate cart subtotal
        $this->keranjang->recalculateSubtotal();

        return $this;
    }

    /**
     * Scope to get items for specific cart
     */
    public function scopeForCart($query, $cartId)
    {
        return $query->where('id_keranjang', $cartId);
    }

    /**
     * Scope to get items for specific product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('id_produk', $productId);
    }

    /**
     * Boot method to handle model events
     */
    protected static function booted()
    {
        // When an item is created, updated, or deleted, recalculate cart subtotal
        static::saved(function ($item) {
            if ($item->keranjang) {
                $item->keranjang->recalculateSubtotal();
            }
        });

        static::deleted(function ($item) {
            if ($item->keranjang) {
                $item->keranjang->recalculateSubtotal();
            }
        });
    }
}
