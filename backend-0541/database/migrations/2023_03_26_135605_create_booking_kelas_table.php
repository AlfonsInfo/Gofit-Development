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
        Schema::create('booking_kelas', function (Blueprint $table) {
            $table->integer('no_booking',true);
            $table->timestamp('tanggal_booking');
            $table->boolean('is_canceled')->default(false);
            $table->boolean('status_kehadiran')->default(false);
            $table->string('no_struk')->index('no_struk');
            $table->integer('id_jadwal_harian')->index('id_jadwal_harian');
            $table->string('id_member')->index('id_member');
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
        Schema::dropIfExists('booking_kelas');
    }
};
