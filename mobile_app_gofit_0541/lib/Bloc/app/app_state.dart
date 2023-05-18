//* State dari AppBloc.dart;

part of 'app_bloc.dart';


class AppState{
  final User? user;
  final Pegawai? pegawai;
  final Member? member;
  final Instruktur? instruktur;
  final JadwalHarian? jadwalHarian;
  AppState({
    this.user ,
    this.pegawai,
    this.instruktur,
    this.member,
    this.jadwalHarian
  });


AppState copyWith({
  User? user,
  Pegawai? pegawai,
  Member? member,
  Instruktur? instruktur,
  JadwalHarian? jadwalHarian
}) {
  return AppState(
    user: user ?? this.user,
    pegawai: pegawai ?? this.pegawai,
    member: member ?? this.member,
    instruktur: instruktur ?? this.instruktur,
    jadwalHarian: jadwalHarian ?? this.jadwalHarian
  );
}


}