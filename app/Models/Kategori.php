<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }

    // Scope untuk kategori yang memiliki produk
    public function scopeWithAvailableProducts($query)
    {
        return $query->whereHas('produk', function ($q) {
            $q->where('stok', '>', 0);
        });
    }

    // Get count of available products
    public function getAvailableProductsCountAttribute()
    {
        return $this->produk()->where('stok', '>', 0)->count();
    }

    // Get total products count
    public function getTotalProductsCountAttribute()
    {
        return $this->produk()->count();
    }
}
