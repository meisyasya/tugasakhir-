<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('balita_id'); // Foreign key ke balita
            $table->date('tanggal_diagnosis');
            $table->integer('usia');
            $table->float('bb'); // Berat Badan
            $table->float('tb'); // Tinggi Badan
            $table->float('imt'); // Indeks Massa Tubuh
            $table->float('lingkar_kepala')->nullable(); //  kolom lingkar_kepala
            $table->string('status_gizi');
            $table->text('hasil_diagnosis');
            $table->timestamps();

            // Menambahkan foreign key ke tabel balitas
            $table->foreign('balita_id')
                  ->references('id')
                  ->on('balitas')
                  ->onDelete('cascade'); // Jika balita dihapus, data diagnosis juga dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
}
