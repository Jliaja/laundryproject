<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('stok_barang', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->string('kategori');
        $table->integer('stok');
        $table->string('satuan'); // liter / kg / pcs
        $table->integer('stok_minimum')->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_barang');
    }
};
