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
            Schema::create('stok_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('stok_barang_id')->constrained('stok_barang')->onDelete('cascade');
        $table->enum('tipe', ['masuk','keluar']);
        $table->integer('jumlah');
        $table->string('keterangan')->nullable();
        $table->timestamp('created_at')->useCurrent();
    });

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('stok_log');
        }
    };
