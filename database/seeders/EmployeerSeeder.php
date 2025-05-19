<?php

namespace Database\Seeders;

use App\Models\Employeer;
use App\Models\Jobb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employeer::factory()
            ->count(10)
            ->create()
            ->each(function ($employeer) {
                Jobb::factory()->count(3)->create([
                    'employeer_id' => $employeer->id
                ]);
            });
    }
}
