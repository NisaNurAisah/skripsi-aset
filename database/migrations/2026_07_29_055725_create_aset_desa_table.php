<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_desa', function (Blueprint $table) {
            $table->id('id_aset_desa');
            $table->string('kode_aset', 10)->unique();
            $table->string('nama_aset', 100);
            $table->string('jenis_aset', 100);
            $table->foreignId('id_lokasi')->constrained('lokasi', 'id_lokasi')->onDelete('cascade');
            $table->date('tahun_perolehan');
            $table->decimal('nilai_perolehan', 19, 2);
            $table->integer('jumlah_aset')->default(1);
            $table->string('kondisi_aset', 20)->nullable();
            $table->string('gambar_aset', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_desa');
    }
};