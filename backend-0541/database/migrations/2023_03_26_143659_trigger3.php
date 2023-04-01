<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared("
        CREATE TRIGGER tambah_deposit AFTER INSERT ON transaksi_deposit_reguler
        FOR EACH ROW
        BEGIN
        UPDATE member
        SET total_deposit_uang = total_deposit_uang + 	NEW.nominal_total
        WHERE member.id_member = (
            SELECT id_member
            FROM transaksi_member
            WHERE transaksi_member.no_struk_transaksi = NEW.no_struk
        );
END;

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tambah_deposit`');
    }
};
