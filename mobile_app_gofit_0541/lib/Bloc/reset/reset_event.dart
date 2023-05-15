part of 'reset_bloc.dart';


//* Representasi Abstrak Semua Event Pada Form login
abstract class ResetEvent{}



//* Representasi Evnt perubahan username
class OldPasswordChanged extends ResetEvent{
  final String? oldPw;
  OldPasswordChanged({this.oldPw});
}

class OldPasswordOnClick extends ResetEvent{
  final bool? state;
  OldPasswordOnClick({this.state});
}
class NewPasswordOnClick extends ResetEvent{
  final bool? state;
  NewPasswordOnClick({this.state});
}


//* Representasi Event perubahan password
class newPasswordChanged extends ResetEvent{
  final String? password;

  newPasswordChanged({this.password});
}


class confirmPasswordChanged extends ResetEvent{
  final String? password;

  confirmPasswordChanged({this.password});
}


//* Login Submitted
class ResetSubmitted extends ResetEvent{
  final String? idPengguna;
  
  ResetSubmitted({this.idPengguna});
}