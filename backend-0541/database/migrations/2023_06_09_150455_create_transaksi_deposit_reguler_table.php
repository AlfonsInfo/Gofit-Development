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
        Schema::create('transaksi_deposit_reguler', function (Blueprint $table) {
            $table->integer('id_deposit_reguler', true);
            $table->timestamp('tanggal_deposit')->useCurrent();
            $table->double('sisa_deposit')->nullable();
            $table->double('nominal_deposit');
            $table->double('nominal_total');
            $table->integer('id_promo')->nullable()->index('id_promo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transaksi_deposit_reguler');
    }
};
