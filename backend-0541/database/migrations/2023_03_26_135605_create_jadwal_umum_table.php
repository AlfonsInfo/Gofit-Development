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
        Schema::create('jadwal_umum', function (Blueprint $table) {
            $table->integer('id_jadwal_umum', true);
            $table->string('hari');
            //*kelas
            //*instruktur
            // $table->foreignUuid('id_instruktur')->references('id_instruktur')->on('instruktur')->nullable();
            $table->string('id_instruktur')->index('id_instruktur')->nullable();
            $table->integer('id_kelas')->nullable()->index('id_kelas');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
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
        Schema::dropIfExists('jadwal_umum');
    }
};
