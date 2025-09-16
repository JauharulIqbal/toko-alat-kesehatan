<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Keranjang extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'subtotal',
        'id_user',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function itemKeranjangs()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_keranjang', 'id_keranjang');
    }
    
    /**
     * Get cart total items count
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->count();
    }

    /**
     * Get cart total quantity
     */
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('jumlah');
    }
}
