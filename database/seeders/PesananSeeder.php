<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        Pesanan::create([
            'user_id' => 2,
            'nama_pelanggan' => 'user1',
            'layanan' => 'Cuci Basah',
            'jumlah' => 12,
            'total_harga' => 12 * 6000,
            'tanggal' => '2025-05-01',
            'status' => 'selesai',
        ]);

        Pesanan::create([
            'user_id' => 2,
            'nama_pelanggan' => 'user1',
            'layanan' => 'Cuci Kering',
            'jumlah' => 111,
            'total_harga' => 111 * 5000,
            'tanggal' => '2025-05-02',
            'status' => 'pending',
        ]);

        Pesanan::create([
            'user_id' => 2,
            'nama_pelanggan' => 'user1',
            'layanan' => 'Setrika',
            'jumlah' => 7,
            'total_harga' => 7 * 4000,
            'tanggal' => '2025-05-03',
            'status' => 'proses',
        ]);

        Pesanan::create([
            'user_id' => 2,
            'nama_pelanggan' => 'user1',
            'layanan' => 'Lengkap (Cuci + Setrika)',
            'jumlah' => 5,
            'total_harga' => 5 * 8000,
            'tanggal' => '2025-05-04',
            'status' => 'selesai',
        ]);

        Pesanan::create([
            'user_id' => 2,
            'nama_pelanggan' => 'user1',
            'layanan' => 'Cuci Kering',
            'jumlah' => 20,
            'total_harga' => 20 * 5000,
            'tanggal' => '2025-05-05',
            'status' => 'batal',
        ]);
    }
}
