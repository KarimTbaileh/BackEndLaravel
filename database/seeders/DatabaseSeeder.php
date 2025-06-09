<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\EmployerSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UsersSeeder::class,]);
        $this->call([EmployerSeeder::class,]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            JobbSeeder::class,
        ]);
        $this->call([
            JobbSeeder::class,
            ApplicationSeeder::class,
        ]);
        $this->call([
            EmployeerSeeder::class,
        ]);
        $this->call([
            JobSeekerSeeder::class,
        ]);
        $this->call([
            CompanySeeder::class
        ]);


    }
}
