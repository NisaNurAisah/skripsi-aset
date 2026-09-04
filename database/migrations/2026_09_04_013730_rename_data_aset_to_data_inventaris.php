<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('data_aset', 'data_inventaris');

        Schema::table('data_inventaris', function (Blueprint $table) {
            $table->renameColumn('id_aset', 'id_inventaris');
            $table->renameColumn('nama_aset', 'nama_inventaris');
            $table->renameColumn('jenis_aset', 'jenis_inventaris');
            $table->renameColumn('kondisi_aset', 'kondisi_inventaris');
            $table->renameColumn('status_aset', 'status_inventaris');
            $table->renameColumn('gambar_aset', 'gambar_inventaris');
            $table->renameColumn('jumlah_aset', 'jumlah_inventaris');
        });

        Schema::table('data_latih', function (Blueprint $table) {
            $table->renameColumn('id_aset', 'id_inventaris');
        });
    }

    public function down(): void
    {
        Schema::table('data_latih', function (Blueprint $table) {
            $table->renameColumn('id_inventaris', 'id_aset');
        });

        Schema::table('data_inventaris', function (Blueprint $table) {
            $table->renameColumn('id_inventaris', 'id_aset');
            $table->renameColumn('nama_inventaris', 'nama_aset');
            $table->renameColumn('jenis_inventaris', 'jenis_aset');
            $table->renameColumn('kondisi_inventaris', 'kondisi_aset');
            $table->renameColumn('status_inventaris', 'status_aset');
            $table->renameColumn('gambar_inventaris', 'gambar_aset');
            $table->renameColumn('jumlah_inventaris', 'jumlah_aset');
        });

        Schema::rename('data_inventaris', 'data_aset');
    }
};