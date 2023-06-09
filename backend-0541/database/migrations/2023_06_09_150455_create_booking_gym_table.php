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
        Schema::create('booking_gym', function (Blueprint $table) {
            $table->integer('no_booking', true);
            $table->date('tanggal_booking');
            $table->boolean('is_canceled')->default(false);
            $table->date('tanggal_sesi_gym');
            $table->boolean('status_kehadiran')->nullable();
            $table->timestamp('waktu_presensi')->nullable();
            $table->integer('id_sesi')->nullable()->index('id_sesi');
            $table->char('id_member', 26)->index('id_member');
            $table->string('no_struk')->nullable()->index('no_struk');
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
        Schema::dropIfExists('booking_gym');
    }
};
