<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lokasi;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_aset', function (Blueprint $table) {
            $table->id('id_aset');
            $table->foreignId('id_lokasi')->constrained('lokasi', 'id_lokasi')->onDelete('cascade');
            $table->string('kode_aset', 10)->unique();
            $table->string('nama_aset', 100);
            $table->string('jenis_aset', 100);
            $table->date('tahun_perolehan');
            $table->decimal('nilai_perolehan', 19, 2);
            $table->string('kondisi_aset', 100)->nullable();
            $table->string('status_aset', 50)->default('Aktif');
            $table->string('gambar_aset', 100)->nullable();
            $table->integer('jumlah_aset')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_aset');
    }
};
