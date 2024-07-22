<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RangeTanggal>
 */
class RangeTanggalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $tanggalMulai = $this->faker->dateTimeBetween('2024-08-01', '2024-12-31');
        $tanggalSelesai = Carbon::create($tanggalMulai)->addDays(rand(5, 30))->format('Y-m-d');
        return [
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai
        ];
    }
}
