part of 'izin_bloc.dart';


//* Representasi Abstrak Semua Event Pada Form login
abstract class IzinFormEvent{}

class ValueNamaInstruktur extends IzinFormEvent{
  final String? nama;

  ValueNamaInstruktur({this.nama});
}

class ValueTanggalPengajuan extends IzinFormEvent{
  final String? tanggalPengajuan;

  ValueTanggalPengajuan({this.tanggalPengajuan});
}

//* Instruktur pengganti
class ValueInstrukturPengganti extends IzinFormEvent{
  final String? instrukturPengganti;
  ValueInstrukturPengganti({this.instrukturPengganti});
}



//* Jadwal Umum Izin
class JadwalUmumIzin extends IzinFormEvent{
  final String? id_jadwal_umum;

  JadwalUmumIzin({this.id_jadwal_umum});
}


//* Pengajuan
class IzinSubmitted extends IzinFormEvent{
  final String? id_instruktur;
  final String? id_instruktur_pengganti;
  final String? id_jadwal_umum;
  
  IzinSubmitted({this.id_instruktur,this.id_instruktur_pengganti, this.id_jadwal_umum});
}