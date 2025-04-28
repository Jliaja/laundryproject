<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Urutan drop: anak ke induk
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('pesanans');
        Schema::dropIfExists('users');

        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // bigIncrements otomatis
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->text('address')->nullable(); // Menambahkan kolom address
            $table->string('profile_picture')->nullable(); // Menambahkan kolom profile_picture
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user'); // Menambahkan kolom role
            $table->boolean('is_admin')->default(false); // Menambahkan kolom is_admin
            $table->timestamps();
        });

        // Tabel pesanans
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_pelanggan');
            $table->string('layanan');
            $table->float('jumlah');
            $table->date('tanggal');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabel transaksis
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Urutan drop: anak ke induk
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('pesanans');
        Schema::dropIfExists('users');
    }
};
