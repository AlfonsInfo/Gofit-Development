part of 'reset_bloc.dart';


class IzinState{
  final String idInstruktur;
  final String tanggalPengajuan;
  final String idInstrukturPengganti;
  final String idJadwalUmum;
  final FormSumbissionStatus formStatus;

  // bool get isValidOldPw => oldPw.isNotEmpty;
  // final String newPassword;
  // bool get isValidNewPw => newPassword.isNotEmpty;
  // User? user;
  

  // final String role;


  IzinState({
    this.idInstruktur= '', 
    this.tanggalPengajuan = '',
    this.idInstrukturPengganti = '',
    this.idJadwalUmum = '',
    this.formStatus = const InitialFormStatus(),
  });

  IzinState copyWith({String? idInstruktur , String? tanggalPengajuan, String? idInstrukturPengganti, String? idJadwalUmum , FormSumbissionStatus? formStatus = const InitialFormStatus()}){
    return IzinState(
      idInstruktur: idInstruktur ?? this.idInstruktur,
      tanggalPengajuan: tanggalPengajuan ?? this.tanggalPengajuan,
      idInstrukturPengganti:  idInstrukturPengganti ?? this.idInstrukturPengganti,
      idJadwalUmum:  idJadwalUmum ?? this.idJadwalUmum,
      formStatus: formStatus ?? this.formStatus,
    );
  }
}