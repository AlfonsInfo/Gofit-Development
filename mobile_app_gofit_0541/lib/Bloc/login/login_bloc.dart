import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
// import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/member.dart';
import 'package:mobile_app_gofit_0541/Models/pegawai.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_auth.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';

part 'login_event.dart';
part 'login_state.dart';


class LoginBloc extends Bloc<LoginEvent, LoginState>{
  AuthRepository authRepo = AuthRepository();
  AppBloc appBloc  = AppBloc();



  LoginBloc() : super(LoginState()){
    on<LoginUsernameChanged>(_onEmailChanged);
    on<LoginPasswordChanged>(_onPasswordChanged);
    on<LoginSubmitted>(_onLoginSubmitted);
    on<Logout>(_onLogoutSubmitted);
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
      if(response != null){
        // inspect(response);  
        emit(state.copyWith(user: response.user ));
        if(response.instruktur != null){
          emit(state.copyWith(instruktur: response.instruktur));
        }
        emit(state.copyWith(user: response.user ));
        emit(state.copyWith(formStatus: SubmissionSuccess()));
      }else{
        return emit(state.copyWith(formStatus: SubmissionFailed()));
      }
    }catch(e){
      emit(state.copyWith(formStatus: SubmissionFailed(exception: e as Exception)));
    }
    // print('mantap jiwa boss');
  }

  _onLogoutSubmitted(Logout  event, Emitter<LoginState> emit){
    emit(state.copyWith(username: '',password: ''));
  }



}