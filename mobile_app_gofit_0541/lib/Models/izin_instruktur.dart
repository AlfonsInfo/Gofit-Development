import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';

class IjinInstruktur{

  //*
  String? idIjin;
  String? idJadwalHarian;
  String? statusIjin;
  String? tanggalPengajuan;
  String? instrukturPengganti;
  JadwalHarian? jadwalHarian;
  //*
  //* String instrukturIjin
  //* String instrukturPengganti
  IjinInstruktur({this.idIjin, this.idJadwalHarian, this.tanggalPengajuan, this.instrukturPengganti , this.statusIjin, this.jadwalHarian});

  factory IjinInstruktur.fromJson(Map<String, dynamic> json){
    return IjinInstruktur(
      idIjin: json['id_ijin'].toString(),
      idJadwalHarian: json['id_jadwal_harian'].toString(), //* id jadwal harian
      tanggalPengajuan: json['tanggal_pengajuan'].toString(),  //* tanggal pengajuan
      statusIjin: json['status_ijin'], //* statusIjin
      instrukturPengganti: json['id_instruktur_pengganti'].toString(), //* Instruktur Pengganti 
      jadwalHarian: json['jadwal_harian'] != null ? JadwalHarian.fromJson(json['jadwal_harian']) :  null,
      );
  }
  
}