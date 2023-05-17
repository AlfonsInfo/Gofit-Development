
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';

class BookingGym{
  String? noBooking;
  String? tanggalBooking;
  String? isCanceled;
  String? tanggalSesiGym;
  String? statusKehadiran;
  // String? idSesi;
  Sesi? sesi;
  String? idMember;

  BookingGym({required this.noBooking, this.idMember, this.isCanceled, this.sesi , this.statusKehadiran, this.tanggalBooking , this.tanggalSesiGym});

  factory BookingGym.fromJson(Map<String, dynamic> json){
    return BookingGym(
      noBooking: json['no_booking'].toString(),
      idMember: json['id_member'].toString(),
      isCanceled: json['is_canceled'].toString(),
      sesi: Sesi.fromJson(json['sesi']),
      tanggalBooking: json['tanggal_booking'].toString(),
      tanggalSesiGym: json['tanggal_sesi_gym'].toString(),
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
