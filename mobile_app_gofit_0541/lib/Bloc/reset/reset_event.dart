part of 'reset_bloc.dart';


//* Representasi Abstrak Semua Event Pada Form login
abstract class ResetEvent{}



//* Representasi Evnt perubahan username
class OldPasswordChanged extends ResetEvent{
  final String? oldPw;
  OldPasswordChanged({this.oldPw});
}



//* Representasi Event perubahan password
class newPasswordChanged extends ResetEvent{
  final String? password;

  newPasswordChanged({this.password});
}


//* Login Submitted
class ResetSubmitted extends ResetEvent{
  final String? idPengguna;
  
  ResetSubmitted({this.idPengguna});
}