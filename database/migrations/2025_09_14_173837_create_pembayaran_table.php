<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_pembayaran')->primary();
            $table->enum('status_pembayaran', ['menunggu', 'sukses', 'gagal', 'refund']);
            $table->decimal('jumlah_pembayaran', 14, 2);
            $table->timestamp('paid_at');

            // FK
            $table->uuid('id_pesanan')->nullable();
            $table->uuid('id_metode_pembayaran')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_metode_pembayaran')->references('id_metode_pembayaran')->on('metode_pembayaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
