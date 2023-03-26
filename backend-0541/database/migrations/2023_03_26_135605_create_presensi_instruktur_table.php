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
        Schema::create('presensi_instruktur', function (Blueprint $table) {
            $table->integer('id_presensi', true);
            $table->timestamp('waktu_presensi')->useCurrent();
            $table->integer('waktu_selesai')->nullable();
            $table->string('status_presensi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi_instruktur');
    }
};
