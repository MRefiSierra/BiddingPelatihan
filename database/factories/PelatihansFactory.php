<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelatihans>
 */
class PelatihansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'prl' => $this->faker->word(),
            'lokasi' => $this->faker->address(),
            'kuota_instruktur' => $this->faker->numberBetween(1, 2),
            'kuota' => $this->faker->numberBetween(1, 1000),
            'id_range_tanggal' => $this->faker->numberBetween(1, 10),
        ];
    }
}
