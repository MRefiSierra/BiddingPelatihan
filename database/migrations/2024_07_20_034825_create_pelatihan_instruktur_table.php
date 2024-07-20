<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelatihan_instruktur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelatihan');
            $table->unsignedBigInteger('id_instruktur');
            $table->date('tanggal_bid')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_pelatihan')->references('id')->on('pelatihans');
            $table->foreign('id_instruktur')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_instruktur');
    }
};
