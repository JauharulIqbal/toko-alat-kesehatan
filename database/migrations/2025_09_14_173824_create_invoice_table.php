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
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_invoice')->primary();
            $table->string('file_path');
            $table->string('kirim_ke_email'); 
            $table->enum('status_kirim', ['berhasil', 'gagal']); 
            $table->timestamp('dikirim_pada')->nullable();
            
            $table->uuid('id_pesanan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
