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
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->id('id_admin'); // Auto-incrementing primary key
            $table->string('nama_admin', 255); // Admin name
            $table->string('username', 255)->unique(); // Unique username
            $table->string('password'); // Hashed password
            $table->string('temp_password')->nullable(); // Optional temporary password
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_admin');
    }
};