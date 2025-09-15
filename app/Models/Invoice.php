<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Invoice extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'invoices';
    protected $primaryKey = 'id_invoice';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'file_path',
        'kirim_ke_email',
        'status_kirim',
        'dikirim_pada',
        'id_pesanan',
    ];

    protected $casts = [
        'dikirim_pada' => 'timestamp',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}