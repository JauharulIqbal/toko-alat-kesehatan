<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

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
    public function users()
    {
        return $this->hasMany(User::class, 'id_kota', 'id_kota');
    }

    // Menggunakan nama plural 'tokos' untuk konsistensi Laravel convention
    public function tokos()
    {
        return $this->hasMany(Toko::class, 'id_kota', 'id_kota');
    }

    // Alias untuk backward compatibility
    public function toko()
    {
        return $this->tokos();
    }

    /**
     * Get approved stores only
     */
    public function approvedStores()
    {
        return $this->tokos()->where('status_toko', 'disetujui');
    }

    /**
     * Get toko count
     */
    public function getTokoCountAttribute()
    {
        return $this->tokos()->count();
    }

    /**
     * Get approved toko count
     */
    public function getApprovedTokoCountAttribute()
    {
        return $this->approvedStores()->count();
    }
}
