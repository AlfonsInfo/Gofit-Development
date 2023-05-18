
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Models/member.dart';
import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';

class BookingKelas{
  String? noBooking;
  String? tanggalBooking;
  String? isCanceled;
  String? statusKehadiran;
  String? noStruk;
  JadwalHarian? jadwalHarian;
  Member? member;

  BookingKelas({required this.noBooking, this.tanggalBooking, this.isCanceled, this.statusKehadiran, this.jadwalHarian, this.member, this.noStruk });

  factory BookingKelas.fromJson(Map<String, dynamic> json){
    return BookingKelas(
      noBooking: json['no_booking'].toString(),
      tanggalBooking: json['tanggal_bo'].toString(),
      isCanceled: json['is_canceled'].toString(),
      jadwalHarian: JadwalHarian.fromJson(json['jadwal_harian']),
      member: Member.fromJson(json['member']),
      noStruk: json['no_struk']?.toString() ?? '',
      statusKehadiran: json['status_kehadiran'].toString(),
    );
  }


}


// class Instruktur{
//   String? idPengguna;
//   String? idInstruktur;
//   String? nama;
//   String? tglLahir;
//   String? alamat;
//   String? noTelp;

//   Instruktur({required this.idPengguna, required this.idInstruktur , required this.nama ,required  this.tglLahir ,required  this.alamat,required  this.noTelp});

//   factory Instruktur.fromJson(Map<String, dynamic> json){
//     return Instruktur(
//       idPengguna: json['id_pengguna'].toString(),
//       idInstruktur: json['id_instruktur'].toString(), 
//       nama: json['nama_instruktur'].toString(), 
//       tglLahir: json['tanggal_lahir_instruktur'].toString(), 
//       alamat: json['alamat_instruktur'].toString(), 
//       noTelp: json['no_telp'].toString()
//       );
//   }
// }
