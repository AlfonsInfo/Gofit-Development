import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
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


  LoginBloc() : super(LoginState()){
    //* on Event state ()
    on<LoginUsernameChanged>(_onEmailChanged);
    on<LoginPasswordChanged>(_onPasswordChanged);
    on<LoginSubmitted>(_onLoginSubmitted);
    on<Logout>(_onLogoutSubmitted);
  }

  //* Mencatat perubahan pada form email
  _onEmailChanged(LoginUsernameChanged event, Emitter<LoginState> emit) 
  {
    emit(state.copyWith(username: event.username));
  }

  //* Mencatat perubahan pada form password
  _onPasswordChanged(LoginPasswordChanged event, Emitter<LoginState> emit)
  {
    emit(state.copyWith(password: event.password));
  }

  //* saat tombol submit di pencet
  _onLoginSubmitted (LoginSubmitted event, Emitter<LoginState> emit) async
  {
    //*State menjadi submitting
    emit(state.copyWith(formStatus: FormSubmitting()));
    try{
      //*request login
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
  }
  //* Akhir dari fungsi tombol submit 

  //* saat logout , hapus data username dan password dari state
  _onLogoutSubmitted(Logout  event, Emitter<LoginState> emit){
    emit(state.copyWith(username: '',password: ''));
  }



}