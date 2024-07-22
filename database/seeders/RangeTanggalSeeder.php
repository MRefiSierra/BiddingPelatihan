<?php

namespace Database\Seeders;

use App\Models\RangeTanggal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangeTanggalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RangeTanggal::factory(20)->create();
    }
}
