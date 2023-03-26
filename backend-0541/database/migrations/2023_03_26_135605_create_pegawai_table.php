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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('id_pegawai')->primary();
            $table->integer('id_pengguna')->index('pegawai_ibfk_1');
            $table->string('nama_pegawai');
            $table->string('jabatan_pegawai');
            $table->timestamp('tgl_lahir_pegawai')->nullable();
            $table->string('no_telp_pegawai');
            $table->string('alamat_pegawai');
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
        Schema::dropIfExists('pegawai');
    }
};
