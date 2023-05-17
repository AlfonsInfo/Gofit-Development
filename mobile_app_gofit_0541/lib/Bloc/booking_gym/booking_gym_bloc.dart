import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/member.dart';
import 'package:mobile_app_gofit_0541/Models/pegawai.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_auth.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_ijin_instruktur.dart';

import 'package:mobile_app_gofit_0541/Repository/repo_sesi.dart';
import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';

part 'booking_event.dart';
part 'booking_state.dart';


class BookingGymBloc extends Bloc<BookingGymEvent, BookingGymState>{
  AuthRepository authRepo = AuthRepository();


  BookingGymBloc() : super(BookingGymState()){
    //* on Event state ()
    on<DateChanged>(_onEmailChanged);
    on<SesiChanged>(_onSesiChanged);
    on<BookingSubmited>(_onLoginSubmitted);
  }

  //* Mencatat perubahan pada form email
  _onEmailChanged(DateChanged event, Emitter<BookingGymState> emit) 
  {
    emit(state.copyWith());
  }
  //* Mencatat perubahan pada form email
  _onSesiChanged(SesiChanged event, Emitter<BookingGymState> emit) 
  {
    emit(state.copyWith());
  }


  //* saat tombol submit di pencet
  _onLoginSubmitted (BookingGymEvent event, Emitter<BookingGymState> emit) async
  {
  //   //*State menjadi submitting
  //   emit(state.copyWith(formStatus: FormSubmitting()));
  //   try{
  //     //*request login
  //     final response = await authRepo.login(username: state.username, password: state.password);
  //     if(response != null){
  //       emit(state.copyWith(user: response.user ));
  //       (response.instruktur != null) ? emit(state.copyWith(instruktur: response.instruktur)) : '';
  //       (response.member != null) ? emit(state.copyWith(member: response.member)) : '';
  //       (response.pegawai != null) ? emit(state.copyWith(member: response.member)) : '';
        
  //       emit(state.copyWith(user: response.user ));
  //       emit(state.copyWith(formStatus: SubmissionSuccess()));
  //     }else{
  //       return emit(state.copyWith(formStatus: SubmissionFailed()));
  //     }
  //   }catch(e){
  //     emit(state.copyWith(formStatus: SubmissionFailed(exception: e as Exception)));
  //   }
  }



}