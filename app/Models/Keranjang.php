<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Keranjang extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_keranjang',
        'id_user',
        'subtotal'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the user that owns the cart
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get all items in this cart
     */
    public function items()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_keranjang', 'id_keranjang');
    }

    /**
     * Get cart items with product details
     */
    public function itemsWithProducts()
    {
        return $this->items()->with(['produk.kategori', 'produk.toko']);
    }

    /**
     * Calculate total items in cart
     */
    public function getTotalItemsAttribute()
    {
        return $this->items()->sum('jumlah');
    }

    /**
     * Calculate total unique products in cart
     */
    public function getTotalProductsAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Recalculate subtotal based on items
     */
    public function recalculateSubtotal()
    {
        $subtotal = $this->items()->get()->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        $this->update(['subtotal' => $subtotal]);
        
        return $subtotal;
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty()
    {
        return $this->items()->count() === 0;
    }

    /**
     * Clear all items from cart
     */
    public function clearItems()
    {
        $this->items()->delete();
        $this->update(['subtotal' => 0]);
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Scope to get cart for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope to get active carts (not empty)
     */
    public function scopeActive($query)
    {
        return $query->has('items');
    }
}