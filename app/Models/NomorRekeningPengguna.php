<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class NomorRekeningPengguna extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nomor_rekening_pengguna';
    protected $primaryKey = 'id_nrp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_nrp',
        'nomor_rekening',
        'id_user',
        'id_metode_pembayaran',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_nrp)) {
                $model->id_nrp = Str::uuid()->toString();
            }
        });
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // relasi ke metode pembayaran
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran', 'id_metode_pembayaran');
    }

    // relasi ke pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_nrp', 'id_nrp');
    }
}
