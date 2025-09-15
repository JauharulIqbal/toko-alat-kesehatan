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
        Schema::create('toko', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_toko')->primary();
            $table->string('nama_toko', 100);
            $table->text('deskripsi_toko')->nullable();
            $table->string('alamat_toko')->nullable();
            $table->enum('status_toko', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');

            $table->uuid('id_kota')->nullable();
            $table->uuid('id_user')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kota')->references('id_kota')->on('kota')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
