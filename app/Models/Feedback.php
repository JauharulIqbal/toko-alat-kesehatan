<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Feedback extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'feedback';
    protected $primaryKey = 'id_feedback';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'message',
        'id_toko',
        'id_user',
    ];

    // Relationships
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}