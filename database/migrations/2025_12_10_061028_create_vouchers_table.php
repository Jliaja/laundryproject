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
        Schema::create('vouchers', function (Blueprint $table) {
    $table->id();
    $table->string('kode')->unique();
    $table->enum('tipe', ['persen', 'nominal']);
    $table->integer('nilai'); // 10 = 10% atau 10000 = Rp 10.000
    $table->integer('stok')->default(0);
    $table->integer('terpakai')->default(0);
    $table->date('masa_berlaku');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
