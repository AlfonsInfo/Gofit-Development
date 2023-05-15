part of 'reset_bloc.dart';


class ResetState{
  final String oldPw;
  final String newPassword;
  final String confirmNewPassword;
  final FormSumbissionStatus formStatus;

  bool get isValidOldPw => oldPw.isNotEmpty;
  bool get isValidNewPw => newPassword.isNotEmpty;
  bool get isNotSame => newPassword == confirmNewPassword;

  // final String role;

  User? user;

  // bool showOld;
  // bool showNew;

  ResetState({
    this.oldPw= '', 
    this.newPassword = '',
    this.confirmNewPassword = '',
    this.formStatus = const InitialFormStatus(),
    // this.showOld = false,
    // this.showNew = false,
  });

  ResetState copyWith({String? oldPw, String? newPassword,String? confirmNewPassword, FormSumbissionStatus? formStatus = const InitialFormStatus(), }){
    return ResetState(
      oldPw: oldPw ?? this.oldPw,
      newPassword: newPassword ?? this.newPassword,
      confirmNewPassword:  confirmNewPassword ?? this.confirmNewPassword,
      formStatus: formStatus ?? this.formStatus,
      // showOld: showOld ?? this.showOld,
      // showNew: showNew ?? this.showNew
    );
  }
}