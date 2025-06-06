<?php

namespace Database\Seeders;

use App\Models\Jobb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jobb::factory()->count(50)->create();

    }
}
