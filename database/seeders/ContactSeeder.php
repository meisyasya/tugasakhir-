<?php

namespace Database\Seeders;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'whatsapp' => '088232649021',
            'email' => 'meisyaa480@gmail.com',
            'whatsapp_url' => 'https://wa.me/qr/7JAY62NYXR46A1',
            'email_url' => 'mailto:meisyaa480@gmail.com?subject=Judul Pesan&body=Isi Pesan',
        ]);
    }
}
