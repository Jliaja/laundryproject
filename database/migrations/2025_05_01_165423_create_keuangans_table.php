<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_pembeli');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran'])->default('pemasukan');
            $table->float('total');
            $table->enum('status_pembayaran', ['lunas', 'belum lunas'])->default('belum lunas');
            $table->string('metode_pembayaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
