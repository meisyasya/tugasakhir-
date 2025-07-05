<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rekomendasi;

class RekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jenis_stunting' => 'Stunting Berat',
                'rekomendasi' => 'Berikan asupan gizi yang seimbang dan lakukan pemantauan pertumbuhan secara berkala.'
            ],
            [
                'jenis_stunting' => 'Stunting Ringan',
                'rekomendasi' => 'Segera konsultasikan ke fasilitas kesehatan dan berikan intervensi gizi darurat.'
            ],
            [
                'jenis_stunting' => 'Tidak Stunting',
                'rekomendasi' => 'Perbaiki pola makan dan kebersihan lingkungan, serta pantau perkembangan anak secara intensif.'
            ],
        ];

        foreach ($data as $item) {
            Rekomendasi::create($item);
        }
    }
}
