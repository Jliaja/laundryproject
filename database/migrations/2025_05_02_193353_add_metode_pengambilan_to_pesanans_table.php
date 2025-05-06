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
    Schema::table('pesanans', function (Blueprint $table) {
        $table->enum('metode_pengambilan', ['ambil', 'antar'])->nullable()->after('status');
        $table->float('jarak')->nullable()->after('metode_pengambilan'); // jika ingin menyimpan jarak (opsional)
    });
}

public function down(): void
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->dropColumn('metode_pengambilan');
        $table->dropColumn('jarak');
    });
}

};
