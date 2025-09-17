<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produk extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar_produk',
        'id_kategori',
        'id_toko',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function itemKeranjang()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_produk', 'id_produk');
    }

    public function itemPesanan()
    {
        return $this->hasMany(ItemPesanan::class, 'id_produk');
    }

    public function scopeAvailable($query)
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('id_kategori', $categoryId);
    }

    public function scopeByStore($query, $storeId)
    {
        return $query->where('id_toko', $storeId);
    }
}
