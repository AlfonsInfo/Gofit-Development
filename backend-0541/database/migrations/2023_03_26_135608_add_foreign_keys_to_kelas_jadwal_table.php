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
        Schema::table('kelas_jadwal', function (Blueprint $table) {
            $table->foreign(['id_jadwal_harian'], 'kelas_jadwal_ibfk_2')->references(['id_jadwal_harian'])->on('jadwal_harian');
            $table->foreign(['id_presensi'], 'kelas_jadwal_ibfk_4')->references(['id_presensi'])->on('presensi_instruktur');
            $table->foreign(['id_kelas'], 'kelas_jadwal_ibfk_1')->references(['id_kelas'])->on('kelas');
            // $table->foreign(['id_ijin'], 'kelas_jadwal_ibfk_3')->references(['id_ijin'])->on('ijin_instruktur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas_jadwal', function (Blueprint $table) {
            $table->dropForeign('kelas_jadwal_ibfk_2');
            $table->dropForeign('kelas_jadwal_ibfk_4');
            $table->dropForeign('kelas_jadwal_ibfk_1');
            // $table->dropForeign('kelas_jadwal_ibfk_3');
        });
    }
};
