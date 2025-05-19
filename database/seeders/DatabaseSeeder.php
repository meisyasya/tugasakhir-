<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AboutSeeder;
use Database\Seeders\HeaderSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\JadwalPosyanduSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RekomendasiSeeder;

class DatabaseSeeder extends Seeder
{
  
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AboutSeeder::class,
            HeaderSeeder::class,
            ContactSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            JadwalPosyanduSeeder::class,
            RekomendasiSeeder::class,
            
    ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
