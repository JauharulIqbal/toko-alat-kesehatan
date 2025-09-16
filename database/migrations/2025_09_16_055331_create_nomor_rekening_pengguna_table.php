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
        Schema::create('nomor_rekening_pengguna', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_nrp')->primary();
            $table->string('nomor_rekening', 50);

            // FK
            $table->uuid('id_user')->nullable();
            $table->uuid('id_metode_pembayaran')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_metode_pembayaran')->references('id_metode_pembayaran')->on('metode_pembayaran')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_rekening_pengguna');
    }
};
