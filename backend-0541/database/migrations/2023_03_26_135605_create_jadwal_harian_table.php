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
        Schema::create('jadwal_harian', function (Blueprint $table) {
            $table->integer('id_jadwal_harian', true);
            $table->date('tanggal_jadwal_harian');
            $table->integer('id_jadwal_umum')->index('id_jadwal_umum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_harian');
    }
};
