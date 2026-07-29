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
        Schema::create('data_latih', function (Blueprint $table) {
            $table->id('id_data_latih');
            $table->foreignId('id_aset')->nullable()->constrained('data_aset', 'id_aset')->onDelete('set null');
            $table->string('jenis_aset', 100);
            $table->string('intensitas_penggunaan', 20); // Rendah/Sedang/Tinggi
            $table->integer('usia_aset'); // dalam tahun (2024 - tahun_perolehan)
            $table->string('label_kondisi', 25); // Baik/Rusak Ringan/Rusak Berat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_latih');
    }
};
