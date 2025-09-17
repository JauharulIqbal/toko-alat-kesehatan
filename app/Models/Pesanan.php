<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pesanan extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'status_pesanan',
        'total_harga_checkout',
        'alamat_pengiriman',
        'catatan',
        'id_user',
        'id_jasa_pengiriman',
    ];

    protected $casts = [
        'total_harga_checkout' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function jasaPengiriman()
    {
        return $this->belongsTo(JasaPengiriman::class, 'id_jasa_pengiriman');
    }

    public function items()
    {
        return $this->hasMany(ItemPesanan::class, 'id_pesanan');
    }

    public function itemPesanans()
    {
        return $this->hasMany(ItemPesanan::class, 'id_pesanan');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_pesanan');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_pesanan');
    }
}