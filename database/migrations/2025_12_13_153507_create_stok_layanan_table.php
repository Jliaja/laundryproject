<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_layanan', function (Blueprint $table) {
            $table->id();

            // nama layanan (harus sama persis dgn pesanan->layanan)
            $table->string('layanan');

            // relasi ke stok barang
            $table->foreignId('stok_barang_id')
                  ->constrained('stok_barang')
                  ->cascadeOnDelete();

            // jumlah stok yang dipakai
            $table->decimal('jumlah', 8, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_layanans');
    }
};
