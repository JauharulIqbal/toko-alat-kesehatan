<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategori extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kategori',
    ];

    // Relationships
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
    public function availableProducts()
    {
        return $this->produk()->where('stok', '>', 0);
    }
}
