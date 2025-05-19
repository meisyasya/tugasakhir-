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
        Schema::create('rekap_stunting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('balita_id');
            $table->date('tanggal');
            $table->integer('usia')->nullable();
            ; // dalam bulan
            $table->float('bb'); // berat badan
            $table->float('tb'); // tinggi badan
            $table->float('imt'); // indeks massa tubuh
            $table->string('status_stunting'); // contoh: "Stunting Ringan", "Stunting Berat"
            $table->timestamps();

            $table->foreign('balita_id')->references('id')->on('balitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_stunting');
    }
};
