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
        Schema::table('ijin_instruktur', function (Blueprint $table) {
            $table->foreign(['id_kelas_jadwal'], 'ijin_instruktur_ibfk_1')->references(['id_kelas_jadwal'])->on('kelas_jadwal');
            $table->foreign(['id_instruktur'], 'ijin_instruktur_ibfk_2')->references(['id_instruktur'])->on('instruktur');
            $table->foreign(['id_instruktur_pengganti'], 'ijin_instruktur_ibfk_3')->references(['id_instruktur'])->on('instruktur');
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
        Schema::table('ijin_instruktur', function (Blueprint $table) {
            $table->dropForeign('ijin_instruktur_ibfk_1');
            $table->dropForeign('ijin_instruktur_ibfk_2');
            $table->dropForeign('ijin_instruktur_ibfk_3');
            // $table->dropForeign('kelas_jadwal_ibfk_3');
        });
    }
};
