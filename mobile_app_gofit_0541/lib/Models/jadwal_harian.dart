import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';

class JadwalHarian{
  String? idJadwalHarian;
  String? tanggal;
  String? status;
  JadwalUmum? jadwalUmum;

  JadwalHarian({required this.idJadwalHarian, required this.tanggal , required this.status ,required  this.jadwalUmum });

  factory JadwalHarian.fromJson(Map<String, dynamic> json){
    return JadwalHarian(
      idJadwalHarian: json['id_jadwal_harian'].toString(),
      tanggal: json['tanggal_jadwal_harian'].toString(), 
      status: json['status'].toString(), 
      jadwalUmum: JadwalUmum.fromJson(json['jadwal_umum']), 
      );
  }

}