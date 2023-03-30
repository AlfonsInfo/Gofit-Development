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
        Schema::create('kelas', function (Blueprint $table) {
        $table->integer('id_kelas', true);
        $table->string('jenis_kelas');
        $table->double('harga_kelas');
        $table->text('deskripsi_kelas');
        // $table->foreignUlid('id_instruktur')->references('id_instruktur')->on('instruktur')->nullable(); //* kayaknya tidak gini
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
        Schema::dropIfExists('kelas');
    }
};
