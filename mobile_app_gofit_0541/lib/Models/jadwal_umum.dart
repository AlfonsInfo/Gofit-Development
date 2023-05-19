
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/izin_instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/kelas.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';

class JadwalUmum{
  String? idJadwalUmum;
  String? hari;
  String? idKelas;
  String? jamMulai;
  String? jamSelesai;
  Kelas? kelas;
  Instruktur? instruktur;

  JadwalUmum({required this.idJadwalUmum, required this.hari , required this.idKelas ,required  this.jamMulai ,required  this.jamSelesai, required this.kelas, required this.instruktur});

  factory JadwalUmum.fromJson(Map<String, dynamic> json){
    return JadwalUmum(
      idJadwalUmum: json['id_jadwal_umum'].toString(),
      hari: json['hari'].toString(), 
      idKelas: json['id_kelas'].toString(), 
      jamMulai: json['jam_mulai'].toString(), 
      jamSelesai: json['jam_selesai'].toString(), 
      kelas: Kelas.fromJson(json['kelas']),
      instruktur : Instruktur.fromJson(json['instruktur']),
      // noTelp: json['no_telp'].toString()
      );
  }
}
