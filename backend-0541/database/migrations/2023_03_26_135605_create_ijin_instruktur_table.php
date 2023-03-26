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
        Schema::create('ijin_instruktur', function (Blueprint $table) {
            $table->integer('id_ijin', true);
            $table->integer('status_ijin');
            $table->integer('tanggal_pengajuan');
            $table->string('id_instruktur');
            $table->string('id_instruktur_pengganti');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ijin_instruktur');
    }
};
