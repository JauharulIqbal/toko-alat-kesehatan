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

    // Relationships
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}