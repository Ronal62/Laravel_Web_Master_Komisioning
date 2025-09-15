<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_admin', function (Blueprint $table) { // Table name: tb_admin
            $table->id('id_admin'); // Auto-increment primary key named 'id_admin'
            $table->string('nama_admin');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps(); // Optional: created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_admin');
    }
};
