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


// DECLARE last_ins_number VARCHAR(255);

// SELECT MAX(CAST(SUBSTR(ins_number, 5) AS UNSIGNED)) INTO last_ins_number FROM `instruktur`;

// CREATE TRIGGER `increment_instruktur_id` BEFORE INSERT ON `instruktur` FOR EACH ROW BEGIN DECLARE last_ins_number VARCHAR(255); DECLARE next_number VARCHAR(255); SELECT MAX(CAST(SUBSTR(ins_number, 5) AS UNSIGNED)) INTO last_ins_number FROM `instruktur`; IF last_ins_number IS NULL THEN SET next_number = 'ins-1'; ELSE SET next_number = CONCAT('ins-', CAST(SUBSTR(last_ins_number, 5) AS UNSIGNED) + 1); END IF; SET NEW.id_instruktur = next_number; END
// ins-1
// 01234


// DROP TRIGGER IF EXISTS `increment_instruktur_id`;CREATE DEFINER=`root`@`localhost` TRIGGER `increment_instruktur_id` BEFORE INSERT ON `instruktur` FOR EACH ROW d`

//* Benar


// BEGIN DECLARE last_ins_number INT;
//   DECLARE next_number VARCHAR(255);
  
//   SELECT MAX(CAST(RIGHT(id_instruktur, LENGTH(id_instruktur) - 4) AS UNSIGNED)) INTO last_ins_number FROM `instruktur`;
  
//   IF last_ins_number IS NULL THEN
//     SET next_number = 'ins-1';
//   ELSE
//     SET next_number = CONCAT('ins-', last_ins_number + 1);
//   END IF;
  
//   SET NEW.id_instruktur = next_number;
//   END


//* ondlete cascade pada tabel child