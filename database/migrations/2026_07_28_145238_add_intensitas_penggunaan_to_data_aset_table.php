<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_aset', function (Blueprint $table) {
            $table->string('intensitas_penggunaan', 20)
                  ->after('jumlah_aset');
        });
    }

    public function down(): void
    {
        Schema::table('data_aset', function (Blueprint $table) {
            $table->dropColumn('intensitas_penggunaan');
        });
    }
};
