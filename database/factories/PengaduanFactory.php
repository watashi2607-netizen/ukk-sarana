<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Siswa;
use App\Models\Kategori;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'kategori_id' => Kategori::factory(),
            'deskripsi' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['masuk', 'selesai']),
            'tanggal_pengaduan' => $this->faker->date(),
        ];
    }
}