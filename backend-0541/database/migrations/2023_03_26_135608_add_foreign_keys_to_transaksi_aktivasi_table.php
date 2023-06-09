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
        Schema::table('transaksi_aktivasi', function (Blueprint $table) {
            $table->foreign(['no_struk'], 'transaksi_aktivasi_ibfk_1')->references(['no_struk_transaksi'])->on('transaksi_member')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_aktivasi', function (Blueprint $table) {
            $table->dropForeign('transaksi_aktivasi_ibfk_1');
        });
    }
};
