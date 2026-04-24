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
        Schema::create('bahan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_bahan'); 
        $table->integer('kategori_id');
        $table->integer('satuan');
        $table->integer('stok_minimal');
        $table->integer('stok_sekarang');
        $table->integer('stok');      
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan');
    }
};
