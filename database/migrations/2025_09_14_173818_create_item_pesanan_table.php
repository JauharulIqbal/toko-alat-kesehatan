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
        Schema::create('item_pesanan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_item_pesanan')->primary();
            $table->decimal('jumlah', 14, 2);
            $table->decimal('subtotal_checkout', 14, 2); 

            // FK
            $table->uuid('id_pesanan')->nullable();
            $table->uuid('id_produk')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pesanan');
    }
};
