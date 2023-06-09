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
            $table->timestamp('waktu_selesai')->nullable();
            $table->string('status_presensi');
            $table->char('id_instruktur', 26)->index('presensi_instruktur_id_instruktur_foreign');
            $table->integer('id_jadwal_harian')->index('id_jadwal_harian');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
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
