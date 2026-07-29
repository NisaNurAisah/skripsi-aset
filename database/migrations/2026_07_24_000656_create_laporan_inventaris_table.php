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
        Schema::create('laporan_inventaris', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->foreignId('id_aset')->nullable()->constrained('data_aset', 'id_aset')->onDelete('set null');
            $table->string('periode', 25);
            $table->string('jenis_aset', 50)->nullable();
            $table->date('tanggal_cetak');
            $table->string('file_laporan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_inventaris');
    }
};
