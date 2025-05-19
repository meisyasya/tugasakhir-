<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create(
            [
                'title' => 'Stunting?',
                'description' => 'Merupakan sebuah Sistem Informasi Untuk Edukasi dan Monitoring Pencegahan Dini Stunting',
                'image' => 'stunting.png'
            ]
            );
    }
}
