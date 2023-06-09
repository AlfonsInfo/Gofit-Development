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
        Schema::table('transaksi_deposit_paket', function (Blueprint $table) {
            $table->foreign(['no_struk'], 'transaksi_deposit_paket_ibfk_2')->references(['no_struk_transaksi'])->on('transaksi_member');
            $table->foreign(['id_promo'], 'transaksi_deposit_paket_ibfk_1')->references(['id_promo'])->on('promo');
            $table->foreign(['id_kelas'], 'transaksi_deposit_paket_ibfk_3')->references(['id_kelas'])->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_deposit_paket', function (Blueprint $table) {
            $table->dropForeign('transaksi_deposit_paket_ibfk_2');
            $table->dropForeign('transaksi_deposit_paket_ibfk_1');
            $table->dropForeign('transaksi_deposit_paket_ibfk_3');
        });
    }
};
