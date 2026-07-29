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
        Schema::create('pengguna', function (Blueprint $table) {
             $table->id('id_pengguna');
             $table->string('nama_pengguna', 255);
             $table->string('username', 100)->unique();
             $table->string('password', 100);
             $table->enum('role', ['Admin', 'Kepala Desa']);
             $table->string('status', 50)->default('Aktif');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
