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
        Schema::create('tb_pelaksana_rtu', function (Blueprint $table) {
            $table->id('id_pelrtu');
            $table->string('nama_pelrtu', 100);
            $table->string('foto_ttd', 225);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pelaksana_rtu');
    }
};
