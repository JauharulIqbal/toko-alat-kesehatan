<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemPesanan extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'item_pesanan';
    protected $primaryKey = 'id_item_pesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'jumlah',
        'subtotal_checkout',
        'id_pesanan',
        'id_produk',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'subtotal_checkout' => 'decimal:2',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}