<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalPosyandu;

class JadwalPosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Posyandu Melati 1', 'tanggal' => '2025-03-10', 'lokasi' => 'Rumah Ibu Herman'],
            ['nama' => 'Posyandu Melati 2', 'tanggal' => '2025-03-12', 'lokasi' => 'Rumah Ibu Tyas'],
            ['nama' => 'Posyandu Melati 3', 'tanggal' => '2025-03-15', 'lokasi' => 'Rumah Ibu Dasirun'],
            ['nama' => 'Posyandu Melati 4', 'tanggal' => '2025-03-18', 'lokasi' => 'Rumah Ibu Indra'],
            ['nama' => 'Posyandu Melati 5', 'tanggal' => '2025-03-20', 'lokasi' => 'Rumah Ibu Sukardi'],
            ['nama' => 'Posyandu Melati 6', 'tanggal' => '2025-03-22', 'lokasi' => 'Rumah Ibu Karno'],
            ['nama' => 'Posyandu Melati 7', 'tanggal' => '2025-03-25', 'lokasi' => 'Rumah Ibu Tugino'],
            ['nama' => 'Posyandu Melati 8', 'tanggal' => '2025-03-28', 'lokasi' => 'Rumah Ibu Sukar'],
        ];

        foreach ($data as $item) {
            JadwalPosyandu::create($item);
        }
    }
}
