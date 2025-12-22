<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use Carbon\Carbon;

class AutoCancelPesanan extends Command
{
    protected $signature = 'auto:cancel-pesanan';
    protected $description = 'Auto cancel pesanan setelah jam 16.00';

    public function handle()
    {
        $now = Carbon::now();

        if ($now->hour >= 16) {
            Pesanan::where('status', 'pending')
                ->whereDate('created_at', Carbon::today())
                ->update([
                    'status' => 'cancel'
                ]);

            $this->info('Pesanan pending berhasil di-cancel');
        }
    }
}
