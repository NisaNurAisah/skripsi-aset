<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasifikasi_kondisi_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_data_aset')
                  ->constrained('data_asets')
                  ->cascadeOnDelete();
            $table->string('hasil_klasifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_kondisi_aset');
    }
};