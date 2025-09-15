<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kota extends Model
{
    use HasUuids;

    protected $table = 'kota';
    protected $primaryKey = 'id_kota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kota',
        'kode_kota',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class, 'id_kota');
    }

    public function tokos()
    {
        return $this->hasMany(Toko::class, 'id_kota');
    }
}