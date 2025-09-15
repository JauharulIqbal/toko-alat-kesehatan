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
        Schema::create('produk', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_produk')->primary();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 14, 2);
            $table->integer('stok');
            $table->string('gambar_produk')->nullable();

            $table->uuid('id_kategori')->nullable();
            $table->uuid('id_toko')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            $table->foreign('id_toko')->references('id_toko')->on('toko')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
