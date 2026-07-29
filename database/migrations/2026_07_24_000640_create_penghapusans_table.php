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
        Schema::create('penghapusan', function (Blueprint $table) {
            $table->id('id_penghapusan');
            $table->foreignId('id_aset')->constrained('data_aset', 'id_aset')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->date('tanggal_penghapusan');
            $table->string('alasan_penghapusan', 255);
            $table->string('status', 10)->default('Diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghapusan');
    }
};
