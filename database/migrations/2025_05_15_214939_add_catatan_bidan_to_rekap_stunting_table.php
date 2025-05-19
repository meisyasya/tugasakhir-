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
        Schema::table('rekap_stunting', function (Blueprint $table) {
            $table->text('catatan_bidan')->nullable()->after('status_stunting');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekap_stunting', function (Blueprint $table) {
            $table->dropColumn('catatan_bidan');
        });
    }
};
