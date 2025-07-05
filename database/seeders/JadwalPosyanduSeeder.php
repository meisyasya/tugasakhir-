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
            ['nama' => 'Posyandu Mawar', 'tanggal' => '2025-03-10', 'lokasi' => 'Posyandu Melati 1'],
            ['nama' => 'Posyandu Melati', 'tanggal' => '2025-03-12', 'lokasi' => 'Posyandu Melati 2'],
            ['nama' => 'Posyandu Dahlia', 'tanggal' => '2025-03-15', 'lokasi' => 'Posyandu Melati 3'],
            ['nama' => 'Posyandu Anggrek', 'tanggal' => '2025-03-18', 'lokasi' => 'Posyandu Melati 4'],
            ['nama' => 'Posyandu Teratai', 'tanggal' => '2025-03-20', 'lokasi' => 'Posyandu Melati 5'],
            ['nama' => 'Posyandu Cempaka', 'tanggal' => '2025-03-22', 'lokasi' => 'Posyandu Melati 6'],
            ['nama' => 'Posyandu Kenanga', 'tanggal' => '2025-03-25', 'lokasi' => 'Posyandu Melati 7'],
            ['nama' => 'Posyandu Bougenville', 'tanggal' => '2025-03-28', 'lokasi' => 'Posyandu Melati 8'],
        ];

        foreach ($data as $item) {
            JadwalPosyandu::create($item);
        }
    }
}
