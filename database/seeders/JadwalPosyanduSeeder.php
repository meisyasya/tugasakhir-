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
            ['nama' => 'Posyandu Mawar', 'tanggal' => '2025-03-10', 'lokasi' => 'Balai Desa A'],
            ['nama' => 'Posyandu Melati', 'tanggal' => '2025-03-12', 'lokasi' => 'Balai Desa B'],
            ['nama' => 'Posyandu Dahlia', 'tanggal' => '2025-03-15', 'lokasi' => 'Balai Desa C'],
            ['nama' => 'Posyandu Anggrek', 'tanggal' => '2025-03-18', 'lokasi' => 'Balai Desa D'],
            ['nama' => 'Posyandu Teratai', 'tanggal' => '2025-03-20', 'lokasi' => 'Balai Desa E'],
            ['nama' => 'Posyandu Cempaka', 'tanggal' => '2025-03-22', 'lokasi' => 'Balai Desa F'],
            ['nama' => 'Posyandu Kenanga', 'tanggal' => '2025-03-25', 'lokasi' => 'Balai Desa G'],
            ['nama' => 'Posyandu Bougenville', 'tanggal' => '2025-03-28', 'lokasi' => 'Balai Desa H'],
        ];

        foreach ($data as $item) {
            JadwalPosyandu::create($item);
        }
    }
}
