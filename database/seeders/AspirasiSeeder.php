<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = \App\Models\InputAspirasi::create([
            'nis' => '1234567890',
            'id_kategori' => 1,
            'lokasi' => 'Kelas 10',
            'keterangan' => 'AC rusak',
        ]);

        \App\Models\Aspirasi::create([
            'status' => 'menunggu',
            'id_kategori' => 1,
            'id_pelaporan' => $input->id_pelaporan,
        ]);
    }
}
