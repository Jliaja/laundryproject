<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
    $table->string('status_pembayaran')->default('pending')->after('status');
    $table->string('invoice_url')->nullable()->after('status_pembayaran');
    $table->string('order_id')->nullable()->after('invoice_url');
});

    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'status_pembayaran',
                'invoice_url',
                'order_id',
                'metode_pengambilan',
                'jarak',
            ]);
        });
    }
};
