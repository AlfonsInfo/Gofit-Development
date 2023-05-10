part of 'login_bloc.dart';


class LoginState{
  final String username;
  bool get isValidUsername => username.length > 3;

  final String password;
  bool get isValidPassword => password.length > 3;
  
  final FormSumbissionStatus formStatus;

  final String role;

  LoginState({
    this.username = '', 
    this.password = '',
    this.formStatus = const InitialFormStatus(),
    this.role = ''
  });

  LoginState copyWith({String? username, String? password, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? role}){
    return LoginState(
      username: username ?? this.username,
      password: password ?? this.password,
      formStatus: formStatus ?? this.formStatus,
      role:  role ?? this.role
    );
  }
}