<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Siswa::factory(10)->create();

        // Tambah siswa test
        \App\Models\Siswa::updateOrCreate(
            ['nis' => '1234567890'],
            [
                'nama' => 'Siswa Test',
                'kelas' => '10',
            ]
        );
    }
}
