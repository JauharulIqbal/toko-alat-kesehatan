<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GuestBook extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'guest_book';
    protected $primaryKey = 'id_guest_book';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'email',
        'message',
    ];
}