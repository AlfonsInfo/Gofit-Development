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
            $table->integer('id_aktivasi', true);
            $table->timestamp('tanggal_aktivasi')->nullable();
            $table->timestamp('tanggal_kadeluarsa')->nullable();
            $table->double('nominal_aktivasi')->default(3000000);
            $table->string('no_struk')->index('no_struk');
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
        Schema::dropIfExists('transaksi_aktivasi');
    }
};
