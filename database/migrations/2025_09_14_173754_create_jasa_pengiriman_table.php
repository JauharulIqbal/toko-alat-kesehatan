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
        Schema::create('jasa_pengiriman', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_jasa_pengiriman')->primary();
            $table->string('nama_jasa_pengiriman');
            $table->decimal('biaya_pengiriman', 14, 2); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa_pengiriman');
    }
};
