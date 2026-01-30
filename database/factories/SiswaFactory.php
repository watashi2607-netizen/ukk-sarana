<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nis' => $this->faker->unique()->numerify('##########'),
            'kelas' => $this->faker->randomElement(['10', '11', '12']),
            'jurusan' => $this->faker->randomElement(['rpl', 'tkj', 'dkv', 'tbsm', 'tkr', 'apt', 'atph']),
        ];
    }
}
