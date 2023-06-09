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
        Schema::create('member', function (Blueprint $table) {
            $table->string('id_member')->primary();
            $table->integer('id_pengguna')->index('id_pengguna');
            $table->string('nama_member');
            $table->timestamp('tgl_lahir_member')->nullable();
            $table->string('no_telp_member');
            $table->timestamp('tgl_kadeluarsa_aktivasi')->nullable();
            $table->double('total_deposit_uang')->default(0);
            $table->timestamp('tgl_gabung_member')->useCurrent();
            $table->integer('total_deposit_paket')->default(0);
            $table->timestamp('tgl_kadeluarsa_paket')->nullable();
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
        Schema::dropIfExists('member');
    }
};
