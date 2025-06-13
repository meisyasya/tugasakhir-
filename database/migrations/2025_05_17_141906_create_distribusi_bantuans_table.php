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
        Schema::create('distribusi_bantuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('balita_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rekap_stunting_id')->nullable(); // <- Ganti nama kolomnya
            $table->date('tanggal_distribusi');
            $table->string('foto_bukti')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('balita_id')->references('id')->on('balitas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rekap_stunting_id')->references('id')->on('rekap_stunting')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_bantuans');
    }
};
