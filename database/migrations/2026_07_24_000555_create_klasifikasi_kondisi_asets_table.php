<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasifikasi_kondisi_aset', function (Blueprint $table) {
            $table->id('id_klasifikasi');
            $table->string('nama_aset_uji', 100);
            $table->string('jenis_aset_uji', 100);
            $table->string('intensitas_penggunaan_uji', 20);
            $table->integer('usia_aset_uji');
            $table->integer('nilai_k')->default(3);
            $table->string('hasil_klasifikasi', 25);
            $table->date('tanggal_klasifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_kondisi_aset');
    }
};