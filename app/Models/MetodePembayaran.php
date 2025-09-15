<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MetodePembayaran extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id_metode_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'metode_pembayaran',
        'tipe_pembayaran',
    ];

    // Relationships
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_metode_pembayaran');
    }
}