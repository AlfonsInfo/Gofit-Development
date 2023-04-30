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
        CREATE TRIGGER kadeluarsa_member
        AFTER INSERT ON transaksi_aktivasi
        FOR EACH ROW
        BEGIN
            DECLARE member_id INT;
            DECLARE tgl_kadeluarsa_aktivasi DATE;
            
            SELECT id_member INTO member_id FROM transaksi_aktivasi JOIN transaksi_member ON transaksi_aktivasi.nomor_struk = transaksi_member.no_struk_transaksi
            WHERE transaksi_aktivasi.id_transaksi_aktivasi = NEW.id_transaksi_aktivasi;
            SELECT tgl_kadeluarsa_aktivasi INTO tgl_kadeluarsa_aktivasi FROM member WHERE id_member = member_id;
            
            IF tgl_kadeluarsa_aktivasi IS NULL THEN
                SET tgl_kadeluarsa_aktivasi = DATE_ADD(NOW(), INTERVAL 1 YEAR);
            ELSE
                SET tgl_kadeluarsa_aktivasi = DATE_ADD(tgl_kadeluarsa_aktivasi, INTERVAL 1 YEAR);
            END IF;
            
            UPDATE member SET tgl_kadeluarsa_aktivasi = tgl_kadeluarsa_aktivasi WHERE id_member = member_id;
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
        DB::unprepared('DROP TRIGGER `kadeluarsa_member`');
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