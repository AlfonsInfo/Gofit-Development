
import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_auth.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';


part 'reset_event.dart';
part 'reset_state.dart';


class ResetBloc extends Bloc<ResetEvent, ResetState>{
  AuthRepository authRepo = AuthRepository();



  ResetBloc() : super(ResetState()){
    on<OldPasswordChanged>(_oldPasswordChanged);
    on<newPasswordChanged>(_newPasswordChanged);
    on<confirmPasswordChanged>(_confirmPasswordChanged);
    on<ResetSubmitted>(_onResetSubmitted);
  }

  _oldPasswordChanged(OldPasswordChanged event, Emitter<ResetState> emit) 
  {
    emit(state.copyWith(oldPw: event.oldPw));
  }

  _newPasswordChanged(newPasswordChanged event, Emitter<ResetState> emit)
  {
    emit(state.copyWith(newPassword: event.password));
  }

  _confirmPasswordChanged(confirmPasswordChanged event, Emitter<ResetState> emit){
    emit(state.copyWith(confirmNewPassword: event.password));
  }

  _onResetSubmitted (ResetSubmitted event, Emitter<ResetState> emit) async
  {
    String resetUrl = '$url/resetbyuser';
      try{
        final response = await http.post(Uri.parse(resetUrl), body:{'id_pengguna' : event.idPengguna, 'old_pw' : state.oldPw , 'new_pw' : state.newPassword});
        final responseData = jsonDecode(response.body);
        if (responseData.containsKey('message')) {
          inspect(responseData);
          emit(state.copyWith(formStatus: SubmissionSuccess()));
          return responseData['message'];
        }else{
          emit(state.copyWith(formStatus: SubmissionFailed()));
        }
      }catch(e){
        return null;
      }
  }



}