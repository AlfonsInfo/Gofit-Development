<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presensi_instruktur', function (Blueprint $table) {
            $table->foreign(['id_instruktur'])->references(['id_instruktur'])->on('instruktur')->onDelete('CASCADE');
            $table->foreign(['id_jadwal_harian'], 'presensi_instruktur_ibfk_1')->references(['id_jadwal_harian'])->on('jadwal_harian')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presensi_instruktur', function (Blueprint $table) {
            $table->dropForeign('presensi_instruktur_id_instruktur_foreign');
            $table->dropForeign('presensi_instruktur_ibfk_1');
        });
    }
};
