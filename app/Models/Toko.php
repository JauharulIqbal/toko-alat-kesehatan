<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Toko extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_toko',
        'deskripsi_toko',
        'alamat_toko',
        'status_toko',
        'id_kota',
        'id_user',
    ];

    // Relationships
    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota', 'id_kota');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }


    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_toko', 'id_toko');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_toko');
    }

    /**
     * Get available products only
     */
    public function availableProducts()
    {
        return $this->produk()->where('stok', '>', 0);
    }
}
