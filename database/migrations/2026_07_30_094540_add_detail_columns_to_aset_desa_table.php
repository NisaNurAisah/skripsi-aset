<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset_desa', function (Blueprint $table) {
            $table->string('nup', 50)->nullable()->after('kode_aset');
            $table->string('ukuran_luas', 50)->nullable()->after('jenis_aset');
            $table->string('tipe', 50)->nullable()->after('ukuran_luas');
            $table->string('atas_hak', 100)->nullable()->after('tipe');
            $table->string('merk_type', 100)->nullable()->after('atas_hak');
            $table->string('nomor_identitas', 50)->nullable()->after('merk_type');
        });
    }

    public function down(): void
    {
        Schema::table('aset_desa', function (Blueprint $table) {
            $table->dropColumn(['nup', 'ukuran_luas', 'tipe', 'atas_hak', 'merk_type', 'nomor_identitas']);
        });
    }
};