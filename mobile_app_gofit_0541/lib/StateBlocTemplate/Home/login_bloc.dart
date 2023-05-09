import 'dart:async';
import 'package:flutter_bloc/flutter_bloc.dart';


part 'login_event.dart';
part 'login_state.dart';


class LoginBloc extends Bloc<LoginEvent, LoginState>{
  // LoginBloc() : super(const LoginState()){
  LoginBloc() : super(LoginState());
}