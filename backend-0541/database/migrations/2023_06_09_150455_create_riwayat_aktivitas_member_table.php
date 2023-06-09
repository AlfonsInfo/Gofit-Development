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
        Schema::create('riwayat_aktivitas_member', function (Blueprint $table) {
            $table->integer('id_riwayat', true);
            $table->string('id_member');
            $table->date('tanggal');
            $table->string('nama_aktivitas');
            $table->string('no_struk')->nullable();
            $table->integer('no_booking')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_aktivitas_member');
    }
};
