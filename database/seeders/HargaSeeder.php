<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Harga;

class HargaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['layanan' => 'Cuci Kering', 'hargaPerKg' => 5000],
            ['layanan' => 'Cuci Setrika', 'hargaPerKg' => 6000],
            ['layanan' => 'Setrika', 'hargaPerKg' => 7000],
        ];

        foreach ($data as $item) {
            Harga::create($item);
        }
    }
}
