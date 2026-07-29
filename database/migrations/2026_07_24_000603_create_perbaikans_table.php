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
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->foreignId('id_aset')->constrained('data_aset', 'id_aset')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->string('deskripsi_kerusakan', 255);
            $table->date('tanggal_perbaikan');
            $table->decimal('biaya_perbaikan', 19, 2)->nullable();
            $table->string('status', 255)->default('Diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbaikan');
    }
};
