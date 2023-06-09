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
        Schema::table('transaksi_member', function (Blueprint $table) {
            $table->foreign(['id_pegawai'], 'transaksi_member_ibfk_1')->references(['id_pegawai'])->on('pegawai');
            $table->foreign(['id_member'], 'transaksi_member_ibfk_2')->references(['id_member'])->on('member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_member', function (Blueprint $table) {
            $table->dropForeign('transaksi_member_ibfk_1');
            $table->dropForeign('transaksi_member_ibfk_2');
        });
    }
};
