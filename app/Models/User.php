<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'kontak',
        'alamat',
        'date_of_birth',
        'gender',
        'role',
        'id_kota',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'timestamp',
        'date_of_birth' => 'date',
        'password' => 'hashed',
    ];

    // Relationships
    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }

    public function tokos()
    {
        return $this->hasMany(Toko::class, 'id_user');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_user');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_user');
    }
}