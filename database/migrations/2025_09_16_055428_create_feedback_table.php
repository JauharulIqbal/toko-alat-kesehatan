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
        Schema::create('feedback', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_feedback')->primary();
            $table->string('nama');
            $table->text('message');

            // FK
            $table->uuid('id_toko')->nullable();
            $table->uuid('id_user')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_toko')->references('id_toko')->on('toko')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
