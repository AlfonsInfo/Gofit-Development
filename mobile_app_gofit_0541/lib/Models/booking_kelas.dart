
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
  String? metodePembayaran; 
  JadwalHarian? jadwalHarian;
  Member? member;

  BookingKelas({required this.noBooking, this.tanggalBooking, this.isCanceled, this.statusKehadiran, this.jadwalHarian, this.member, this.noStruk , this.metodePembayaran});

  factory BookingKelas.fromJson(Map<String, dynamic> json){
    return BookingKelas(
      noBooking: json['no_booking'].toString(),
      tanggalBooking: json['tanggal_booking'].toString(),
      isCanceled: json['is_canceled'].toString(),
      jadwalHarian: JadwalHarian.fromJson(json['jadwal_harian']),
      metodePembayaran : json['metode_pembayaran']?.toString() ?? '',
      member: (json['member'] != null) ? Member.fromJson(json['member']) : null  ,
      noStruk: json['no_struk']?.toString() ?? '',
      statusKehadiran: json['status_kehadiran']?.toString() ?? '',
    );
  }


}

