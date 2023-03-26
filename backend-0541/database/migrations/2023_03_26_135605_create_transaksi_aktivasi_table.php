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
        Schema::create('transaksi_aktivasi', function (Blueprint $table) {
            $table->integer('id_aktivasi')->primary();
            $table->integer('tanggal_aktivasi');
            $table->double('nominal_aktivasi')->default(3000000);
            $table->string('no_struk')->index('no_struk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_aktivasi');
    }
};
