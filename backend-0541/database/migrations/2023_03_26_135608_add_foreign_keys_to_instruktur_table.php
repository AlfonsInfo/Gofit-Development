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
        Schema::table('instruktur', function (Blueprint $table) {
            $table->foreign(['id_pengguna'], 'instruktur_ibfk_1')->references(['id_pengguna'])->on('pengguna')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instruktur', function (Blueprint $table) {
            $table->dropForeign('instruktur_ibfk_1');
        });
    }
};
