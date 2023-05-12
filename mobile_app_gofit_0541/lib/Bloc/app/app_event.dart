part of 'app_bloc.dart';

abstract class AppEvent{}



class SaveUserInfo extends AppEvent{
  final User? user;
  final Pegawai? pegawai;
  final Member? member;
  final Instruktur? instruktur;
  SaveUserInfo({this.user, this.pegawai, this.member , this.instruktur});
}

