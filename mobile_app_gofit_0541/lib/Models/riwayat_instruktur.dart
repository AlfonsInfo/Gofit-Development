import 'package:mobile_app_gofit_0541/Models/izin_instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/presensi_instruktur.dart';

class RiwayatInstruktur{
  // ? idPresensi;
  PresensiInstruktur? presensiInstruktur;
  IjinInstruktur? ijinInstruktur;

  RiwayatInstruktur({this.presensiInstruktur, this.ijinInstruktur});

  // RiwayatMember({required this.idRiwayat, this.idMember, this.tanggal, this.noStruk, this.noBooking,this.namaAktivitas});

  factory RiwayatInstruktur.fromJson(Map<String, dynamic> json){
    if(json['jenis_data'] == 'presensi'){
      return RiwayatInstruktur(presensiInstruktur: PresensiInstruktur.fromJson(json)); 
    }else if(json['jenis_data'] == 'ijin'){
      return RiwayatInstruktur(ijinInstruktur: IjinInstruktur.fromJson(json));
    }else{
      return RiwayatInstruktur();
    }
  }
  
}