<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Header;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Header::create(
            [
                'title' => 'Sistem Informasi Edukasi dan Monitoring Pencegahan Stunting Berbasis Website',
                'description' => 'Merupakan sebuah Sistem Informasi Untuk Edukasi dan Monitoring Pencegahan Dini Stunting',
                'image' => 'stunting.png'
            ]
            );
        
    }
}
