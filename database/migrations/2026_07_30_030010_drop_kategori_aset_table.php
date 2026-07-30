<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('kategori_aset');
    }

    public function down(): void
    {
        Schema::create('kategori_aset', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('jenis_kategori', 100);
            $table->string('kode_kategori', 50);
            $table->timestamps();
        });
    }
};