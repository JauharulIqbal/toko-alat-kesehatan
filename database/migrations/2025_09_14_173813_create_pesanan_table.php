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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_pesanan')->primary();
            $table->enum('status_pesanan', ['menunggu', 'sukses', 'gagal', 'dikirim']);
            $table->decimal('total_harga_checkout', 14, 2);

            // FK
            $table->uuid('id_user')->nullable();
            $table->uuid('id_jasa_pengiriman')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_jasa_pengiriman')->references('id_jasa_pengiriman')->on('jasa_pengiriman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
