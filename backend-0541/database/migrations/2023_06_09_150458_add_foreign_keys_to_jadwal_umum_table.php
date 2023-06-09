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
        Schema::table('jadwal_umum', function (Blueprint $table) {
            $table->foreign(['id_instruktur'], 'jadwal_umum_ibfk_2')->references(['id_instruktur'])->on('instruktur');
            $table->foreign(['id_kelas'], 'jadwal_umum_ibfk_1')->references(['id_kelas'])->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal_umum', function (Blueprint $table) {
            $table->dropForeign('jadwal_umum_ibfk_2');
            $table->dropForeign('jadwal_umum_ibfk_1');
        });
    }
};
