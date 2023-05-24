

import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';

class PresensiInstruktur{
    String? idPresensi;
    String? waktuMulai;
    String? waktuSelesai;
    String? statusPresensi;
    String? idInstruktur;
    String? idJadwalharian;
    JadwalHarian? jadwalHarian;


    PresensiInstruktur({this.idPresensi, this.idInstruktur , this.waktuMulai, this.waktuSelesai, this.statusPresensi, this.idJadwalharian ,this.jadwalHarian});

    factory PresensiInstruktur.fromJson(Map<String, dynamic> json){
      return PresensiInstruktur(
        idPresensi: json['id_presensi'].toString(),
        waktuMulai: json['waktu_mulai'].toString(),
        waktuSelesai: json['waktuSelesai'].toString(),
        statusPresensi: json['status_presensi'].toString(),
        idInstruktur: json['id_instruktur'].toString(),
        idJadwalharian: json['id_jadwal_harian'].toString(),
        jadwalHarian: JadwalHarian.fromJson(json['jadwal_harian']),
    );
  }
}