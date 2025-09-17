<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }

    public function toko()
    {
        return $this->hasOne(Toko::class, 'id_user', 'id_user');
    }

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class, 'id_user', 'id_user');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_user', 'id_user');
    }

    public function nomorRekeningPengguna()
    {
        return $this->hasMany(NomorRekeningPengguna::class, 'id_user', 'id_user');
    }

    /**
     * Get or create keranjang for this user
     */
    public function getOrCreateKeranjang()
    {
        if (!$this->keranjang) {
            $this->keranjang = Keranjang::create([
                'id_keranjang' => Str::uuid(),
                'id_user' => $this->id_user,
                'subtotal' => 0
            ]);
        }

        return $this->keranjang;
    }

    // Accessor untuk mengatasi masalah casting
    public function getDateOfBirthAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        // Jika sudah Carbon instance, return as is
        if ($value instanceof \Carbon\Carbon) {
            return $value;
        }

        // Jika integer (timestamp), convert ke Carbon
        if (is_numeric($value)) {
            return \Carbon\Carbon::createFromTimestamp($value);
        }

        // Jika string date, parse ke Carbon
        return \Carbon\Carbon::parse($value);
    }

    // Mutator untuk memastikan date_of_birth tersimpan dengan benar
    public function setDateOfBirthAttribute($value)
    {
        if (is_null($value) || $value === '') {
            $this->attributes['date_of_birth'] = null;
        } else {
            $this->attributes['date_of_birth'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
        }
    }
}
