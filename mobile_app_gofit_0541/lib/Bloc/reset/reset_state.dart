part of 'reset_bloc.dart';


class ResetState{
  final String oldPw;
  bool get isValidOldPw => oldPw.isNotEmpty;

  final String newPassword;
  bool get isValidNewPw => newPassword.isNotEmpty;
  
  final FormSumbissionStatus formStatus;

  // final String role;

  User? user;

  ResetState({
    this.oldPw= '', 
    this.newPassword = '',
    this.formStatus = const InitialFormStatus(),
  });

  ResetState copyWith({String? oldPw, String? newPassword, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? role,User? user}){
    return ResetState(
      oldPw: oldPw ?? this.oldPw,
      newPassword: newPassword ?? this.newPassword,
      formStatus: formStatus ?? this.formStatus,
    );
  }
}