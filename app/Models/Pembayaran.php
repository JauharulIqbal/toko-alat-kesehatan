<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pembayaran extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'status_pembayaran',
        'jumlah_pembayaran',
        'paid_at',
        'id_pesanan',
        'id_metode_pembayaran',
    ];

    protected $casts = [
        'jumlah_pembayaran' => 'decimal:2',
        'paid_at' => 'timestamp',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }
}