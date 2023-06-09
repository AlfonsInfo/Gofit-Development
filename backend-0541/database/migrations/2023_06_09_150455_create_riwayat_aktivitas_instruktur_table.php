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
        Schema::create('riwayat_aktivitas_instruktur', function (Blueprint $table) {
            $table->integer('id_riwayat');
            $table->string('id_instruktur')->nullable();
            $table->string('nama_aktivitas')->nullable();
            $table->integer('id_jadwal_harian')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_aktivitas_instruktur');
    }
};
