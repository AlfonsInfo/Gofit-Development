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
            $table->foreign(['id_instruktur'], 'ijin_instruktur_ibfk_2')->references(['id_instruktur'])->on('instruktur')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_jadwal_harian'], 'ijin_instruktur_ibfk_1')->references(['id_jadwal_harian'])->on('jadwal_harian')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_instruktur_pengganti'], 'ijin_instruktur_ibfk_3')->references(['id_instruktur'])->on('instruktur')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            $table->dropForeign('ijin_instruktur_ibfk_2');
            $table->dropForeign('ijin_instruktur_ibfk_1');
            $table->dropForeign('ijin_instruktur_ibfk_3');
        });
    }
};
