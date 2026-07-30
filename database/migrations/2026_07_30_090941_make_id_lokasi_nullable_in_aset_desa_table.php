<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset_desa', function (Blueprint $table) {
            $table->dropForeign(['id_lokasi']);
        });

        Schema::table('aset_desa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lokasi')->nullable()->change();
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('aset_desa', function (Blueprint $table) {
            $table->dropForeign(['id_lokasi']);
        });

        Schema::table('aset_desa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lokasi')->nullable(false)->change();
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });
    }
};