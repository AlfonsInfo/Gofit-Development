part of 'izin_bloc.dart';


class IzinState{
  final String idInstruktur;
  String tanggalPengajuan = datePengajuan();
  final String idInstrukturPengganti;
  final String idJadwalUmum;
  final FormSumbissionStatus formStatus;

  static String datePengajuan(){
    DateTime now = DateTime.now();
    DateTime date = DateTime(now.year, now.month, now.day);
    var formatter = DateFormat('dd-MM-yyyy');
    String stringDate = formatter.format(date);
    return stringDate;
  }

  IzinState({
    this.idInstruktur= '', 
    this.idInstrukturPengganti = '',
    this.idJadwalUmum = '',
    this.formStatus = const InitialFormStatus(),
  });



  IzinState copyWith({String? idInstruktur , String? tanggalPengajuan, String? idInstrukturPengganti, String? idJadwalUmum , FormSumbissionStatus? formStatus = const InitialFormStatus()}){
    return IzinState(
      idInstruktur: idInstruktur ?? this.idInstruktur,
      idInstrukturPengganti:  idInstrukturPengganti ?? this.idInstrukturPengganti,
      idJadwalUmum:  idJadwalUmum ?? this.idJadwalUmum,
      formStatus: formStatus ?? this.formStatus,
    );
  }
}