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
  final String? idJadwalUmum;

  JadwalUmumIzin({this.idJadwalUmum});
}


//* Pengajuan
class IzinSubmitted extends IzinFormEvent{
  final String? idInstruktur;
  final String? idInstrukturPengganti;
  final String? idJadwalUmum;
  
  IzinSubmitted({this.idInstruktur,this.idInstrukturPengganti, this.idJadwalUmum});
}