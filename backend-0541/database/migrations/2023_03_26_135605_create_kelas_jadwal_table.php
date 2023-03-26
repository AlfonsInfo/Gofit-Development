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
        Schema::create('kelas_jadwal', function (Blueprint $table) {
            $table->integer('id_kelas_jadwal', true);
            $table->integer('jumlah_peserta');
            $table->string('status');
            $table->integer('id_ijin')->index('id_ijin');
            $table->integer('id_presensi')->index('id_presensi');
            $table->integer('id_kelas')->nullable()->index('id_kelas');
            $table->integer('id_jadwal_harian')->index('id_jadwal_harian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_jadwal');
    }
};
