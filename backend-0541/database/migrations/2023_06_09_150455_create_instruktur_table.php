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
        Schema::create('instruktur', function (Blueprint $table) {
            $table->string('id_instruktur')->primary();
            $table->integer('id_pengguna')->index('instruktur_ibfk_1');
            $table->string('nama_instruktur');
            $table->timestamp('tanggal_lahir_instruktur')->useCurrentOnUpdate()->useCurrent();
            $table->string('alamat_instruktur');
            $table->string('no_telp_instruktur');
            $table->integer('akumulasi_terlambat')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('instruktur');
    }
};
