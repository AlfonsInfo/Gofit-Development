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
            $table->integer('id_jadwal_harian')->index();
            $table->string('status_ijin');
            $table->date('tanggal_pengajuan');
            $table->string('id_instruktur');
            $table->string('id_instruktur_pengganti');
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
        Schema::dropIfExists('ijin_instruktur');
    }
};
