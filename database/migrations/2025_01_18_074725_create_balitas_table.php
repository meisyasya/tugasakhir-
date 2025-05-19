<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('balitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('img')->nullable();
            $table->float('berat_badan', 5, 2);
            $table->float('tinggi_badan', 5, 2);
            $table->float('lingkar_kepala', 5, 2);
            $table->string('nik_ibu');
            $table->string('nama_ibu');
            $table->text('alamat_lengkap');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('posyandu');
            $table->timestamps();



            

    }); 
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balitas');
    }
};
