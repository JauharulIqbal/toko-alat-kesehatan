<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JasaPengiriman extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'jasa_pengiriman';
    protected $primaryKey = 'id_jasa_pengiriman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_jasa_pengiriman',
        'biaya_pengiriman',
    ];

    protected $casts = [
        'biaya_pengiriman' => 'decimal:2',
    ];

    // Relationships
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_jasa_pengiriman');
    }
}