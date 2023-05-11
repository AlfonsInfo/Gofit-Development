part of 'login_bloc.dart';


class LoginState{
  final String username;
  bool get isValidUsername => username.isNotEmpty;

  final String password;
  bool get isValidPassword => password.isNotEmpty;
  
  final FormSumbissionStatus formStatus;

  // final String role;

  User? user;

  LoginState({
    this.username = '', 
    this.password = '',
    this.formStatus = const InitialFormStatus(),
    this.user 
  });

  LoginState copyWith({String? username, String? password, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? role,User? user}){
    return LoginState(
      username: username ?? this.username,
      password: password ?? this.password,
      formStatus: formStatus ?? this.formStatus,
      user: user ?? this.user
    );
  }
}