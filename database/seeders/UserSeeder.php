<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'meisyaa480@gmail.com'],
            [
                'name' => 'Meisya Anggraeni',
                'password' => Hash::make('meisya12'),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Bidan user
        $bidan = User::firstOrCreate(
            ['email' => 'ainusafaf28@gmail.com'],
            [
                'name' => 'Bidan Ainus',
                'password' => Hash::make('bidan123'),
            ]
        );

        if (!$bidan->hasRole('bidan')) {
            $bidan->assignRole('bidan');
        }

        // Pemerintah user
        $pemerintah = User::firstOrCreate(
            ['email' => 'pemerintahdesabpayung@gmail.com'],
            [
                'name' => 'PemDes',
                'password' => Hash::make('pemdes123'),
            ]
        );

        if (!$pemerintah->hasRole('pemdes')) {
            $pemerintah->assignRole('pemdes');
        }

        // Kader users (8 orang)
        for ($i = 1; $i <= 8; $i++) {
            $kader = User::firstOrCreate(
                ['email' => "kader{$i}@example.com"],
                [
                    'name' => "Kader {$i}",
                    'password' => Hash::make('kader123'),
                    'posyandu' => "Posyandu Melati {$i}", // Tambahkan ini
                ]
            );

            if (!$kader->hasRole('kader')) {
                $kader->assignRole('kader');
            }

            // Kalau posyandu belum keisi karena user sudah ada, update saja:
            if (!$kader->posyandu) {
                $kader->update(['posyandu' => "Posyandu Melati {$i}"]);
            }
        }

            }
}
