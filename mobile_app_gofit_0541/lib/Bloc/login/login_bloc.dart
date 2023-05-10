import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Repository/auth_repository.dart';

part 'login_event.dart';
part 'login_state.dart';


class LoginBloc extends Bloc<LoginEvent, LoginState>{
  AuthRepository authRepo = AuthRepository();

  // LoginBloc() : super(const LoginState()){
  LoginBloc() : super(LoginState()){
    on<LoginUsernameChanged>(_onEmailChanged);
    on<LoginPasswordChanged>(_onPasswordChanged);
    on<LoginSubmitted>(_onLoginSubmitted);
  }

  _onEmailChanged(LoginUsernameChanged event, Emitter<LoginState> emit) 
  {
    emit(state.copyWith(username: event.username));
  }

  _onPasswordChanged(LoginPasswordChanged event, Emitter<LoginState> emit)
  {
    emit(state.copyWith(password: event.password));
  }

  _onLoginSubmitted (LoginSubmitted event, Emitter<LoginState> emit) async
  {
    emit(state.copyWith(formStatus: FormSubmitting()));
    try{
      final response = await authRepo.login(username: state.username, password: state.password);
      inspect(response);
      if(response != null){
        // print('masuk sini kok');
        emit(state.copyWith(formStatus: SubmissionSuccess()));
        if(response.pegawai != null){ 
          emit(state.copyWith(role: 'pegawai'));
        }
        if(response.member != null){ 
          emit(state.copyWith(role: 'member'));
        }
        if(response.instruktur !=null){ 
          emit(state.copyWith(role: 'instruktur'));
        }
        print(state.role);
        // emit(state.copyWith(role: response. ));
        // emit(state.copyWith(role: ))
        //* User yang login disimpan di sharedPreferences atau states ?
      }else{
        return emit(state.copyWith(formStatus: SubmissionFailed()));
      }
    }catch(e){
      emit(state.copyWith(formStatus: SubmissionFailed(exception: e as Exception)));
    }
    // print('mantap jiwa boss');
  }
  // @override
  // Stream<LoginState> mapEventToState(LoginEvent event) async*{


}