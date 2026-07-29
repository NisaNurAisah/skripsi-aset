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
        Schema::create('log_aktivitas', function (Blueprint $table) {
           $table->id('id_log');
           $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
           $table->string('aktivitas', 255);
           $table->timestamp('waktu')->useCurrent();
           $table->string('keterangan', 255)->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
