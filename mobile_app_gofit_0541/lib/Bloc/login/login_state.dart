part of 'login_bloc.dart';


class LoginState{
  final String username;
  final String password;
  User? user;
  Pegawai? pegawai;
  Instruktur? instruktur;
  Member? member;

  bool get isValidUsername => username.isNotEmpty;
  bool get isValidPassword => password.isNotEmpty;
  
  final FormSumbissionStatus formStatus;

  // final String role;



  LoginState({
    this.username = '', 
    this.password = '',
    this.formStatus = const InitialFormStatus(),
    this.user ,
    this.instruktur,
    this.member ,
    this.pegawai
  });

  LoginState copyWith({String? username, String? password, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? role,User? user, Instruktur? instruktur, Pegawai? pegawai, Member? member}){
    return LoginState(
      username: username ?? this.username,
      password: password ?? this.password,
      formStatus: formStatus ?? this.formStatus,
      user: user ?? this.user,
      instruktur: instruktur ?? this.instruktur,
      member : member  ?? this.member,
      pegawai : pegawai  ?? this.pegawai 
    );
  }
}