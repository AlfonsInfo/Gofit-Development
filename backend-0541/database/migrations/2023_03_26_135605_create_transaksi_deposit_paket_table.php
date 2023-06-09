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
        Schema::create('transaksi_deposit_paket', function (Blueprint $table) {
            $table->integer('id_deposit_paket', true);
            $table->timestamp('tanggal_deposit')->useCurrent();
            $table->double('nominal_deposit_kelas');
            $table->double('nominal_uang');
            $table->timestamp('tanggal_kadeluarsa')->nullable();
            $table->integer('id_promo')->index('id_promo');
            $table->string('no_struk')->index('no_struk');
            $table->integer('id_kelas')->index('id_kelas');
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
        Schema::dropIfExists('transaksi_deposit_paket');
    }
};
