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
        if (Schema::hasColumn('klasifikasi_kondisi_aset', 'id_data_aset')) {
            $table->dropForeign(['id_data_aset']);
            $table->dropColumn('id_data_aset');
        }
        if (!Schema::hasColumn('klasifikasi_kondisi_aset', 'nama_aset_uji')) {
            $table->string('nama_aset_uji', 100)->after('id_klasifikasi');
        }
        if (!Schema::hasColumn('klasifikasi_kondisi_aset', 'jenis_aset_uji')) {
            $table->string('jenis_aset_uji', 100)->after('nama_aset_uji');
        }
        if (!Schema::hasColumn('klasifikasi_kondisi_aset', 'intensitas_penggunaan_uji')) {
            $table->string('intensitas_penggunaan_uji', 20)->after('jenis_aset_uji');
        }
        if (!Schema::hasColumn('klasifikasi_kondisi_aset', 'usia_aset_uji')) {
            $table->integer('usia_aset_uji')->after('intensitas_penggunaan_uji');
        }
    });
}

public function down(): void
{
    //
}
};
