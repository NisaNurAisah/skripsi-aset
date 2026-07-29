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
    Schema::table('klasifikasi_kondisi_aset', function (Blueprint $table) {
        $table->dropForeign(['id_data_aset']);
        $table->dropColumn('id_data_aset');
        $table->string('nama_aset_uji', 100)->after('id_klasifikasi');
        $table->string('jenis_aset_uji', 100)->after('nama_aset_uji');
        $table->string('intensitas_penggunaan_uji', 20)->after('jenis_aset_uji');
        $table->integer('usia_aset_uji')->after('intensitas_penggunaan_uji');
    });
}

public function down(): void
{
    Schema::table('klasifikasi_kondisi_aset', function (Blueprint $table) {
        $table->dropColumn(['nama_aset_uji', 'jenis_aset_uji', 'intensitas_penggunaan_uji', 'usia_aset_uji']);
        $table->foreignId('id_data_aset')->constrained('data_aset', 'id_aset')->onDelete('cascade');
    });
}
};
