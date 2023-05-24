import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Models/izin_instruktur.dart';

class JadwalHarian{
  String? idJadwalHarian;
  String? tanggal;
  String? status;
  String? jamMulai;
  String? jamSelesai;
  JadwalUmum? jadwalUmum;
  IjinInstruktur? ijinInstruktur;


  JadwalHarian({required this.idJadwalHarian, required this.tanggal , required this.status ,required  this.jadwalUmum , required this.jamMulai , required this.jamSelesai , required this.ijinInstruktur});

  factory JadwalHarian.fromJson(Map<String, dynamic> json){
    return JadwalHarian(
      idJadwalHarian: json['id_jadwal_harian'].toString(),
      tanggal: json['tanggal_jadwal_harian'].toString(), 
      status: json['status'].toString(), 
      jadwalUmum: json['jadwal_umum'] != null ? JadwalUmum.fromJson(json['jadwal_umum']) : null, 
      jamMulai: json['jam_mulai'] != null ? json['jam_mulai'].toString()  : null,
      jamSelesai: json['jam_selesai'] != null ? json['jam_selesai'].toString()  : null,
      ijinInstruktur: json['ijin_instruktur'] != null ? IjinInstruktur.fromJson(json['ijin_instruktur']) :  null,
  );
  }

}