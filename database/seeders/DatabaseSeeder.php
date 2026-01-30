<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        // Create sample data
        Kategori::create(['ket_kategori' => 'Sarana']);
        Kategori::create(['ket_kategori' => 'Prasarana']);

        Siswa::create(['nis' => '12345', 'nama' => 'Siswa 1', 'kelas' => '10']);
        Siswa::create(['nis' => '12346', 'nama' => 'Siswa 2', 'kelas' => '11']);
        Siswa::create(['nis' => '12347', 'nama' => 'Siswa 3', 'kelas' => '12']);
        Siswa::create(['nis' => '1234567890', 'nama' => 'Siswa Test', 'kelas' => '10']);

        // Create sample aspirasi
        $input = \App\Models\InputAspirasi::create([
            'nis' => '1234567890',
            'id_kategori' => 1, // Sarana
            'lokasi' => 'Ruang Kelas 10',
            'keterangan' => 'AC rusak dan tidak dingin',
            'gambar' => 'RFakRs4ir03gw3Y3RHRpRYGUnaUhukIi6hTXN5Dj.jpg', // Existing image
        ]);

        \App\Models\Aspirasi::create([
            'status' => 'menunggu',
            'id_kategori' => 1,
            'id_pelaporan' => $input->id_pelaporan,
        ]);
    }
}
