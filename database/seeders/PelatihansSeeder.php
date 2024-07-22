<?php

namespace Database\Seeders;

use App\Models\Pelatihans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelatihans::factory(20)->create();
    }
}
