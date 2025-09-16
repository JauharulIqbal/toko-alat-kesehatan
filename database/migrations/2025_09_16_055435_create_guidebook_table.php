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
        Schema::create('guest_book', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id_guest_book')->primary();
            $table->string('nama');
            $table->string('email'); 
            $table->text('message'); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_book');
    }
};
