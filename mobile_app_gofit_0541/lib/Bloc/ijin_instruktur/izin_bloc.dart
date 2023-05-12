
import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
// import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Repository/auth_repository.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';
import 'package:mobile_app_gofit_0541/Config/constant.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';


part 'izin_event.dart';
part 'izin_state.dart';


class IzinBloc extends Bloc<IzinFormEvent, IzinState>{
  AuthRepository authRepo = AuthRepository();
  AppBloc appBloc  = AppBloc();



  IzinBloc() : super(IzinState()){
    on<ValueNamaInstruktur>(_valueNama);
    on<ValueTanggalPengajuan>(_ValueTanggal);
    on<ValueInstrukturPengganti>(_valueInstrukturPengganti);
    on<JadwalUmumIzin>(_ValueJadwalUmumIzin);
  }

  _valueNama(ValueNamaInstruktur event, Emitter<IzinState> emit) 
  {
    // emit(state.copyWith(oldPw: event.oldPw));
  }

  _ValueTanggal(ValueTanggalPengajuan event, Emitter<IzinState> emit)
  {
    // emit(state.copyWith(newPassword: event.password));
  }

  _valueInstrukturPengganti(ValueInstrukturPengganti event, Emitter<IzinState> emit){

  }

  _ValueJadwalUmumIzin (JadwalUmumIzin event, Emitter<IzinState> emit) async
  {
    // String resetUrl = '$url/resetbyuser';
    //   try{
    //     final response = await http.post(Uri.parse(resetUrl), body:{'id_pengguna' : event.idPengguna, 'old_pw' : state.oldPw , 'new_pw' : state.newPassword});
    //     final responseData = jsonDecode(response.body);
    //     if (responseData.containsKey('message')) {
    //       inspect(responseData);
    //       emit(state.copyWith(formStatus: SubmissionSuccess()));
    //       return responseData['message'];
    //     }else{
    //       emit(state.copyWith(formStatus: SubmissionFailed()));
    //     }

    //   }catch(e){
    //     return null;
    //   }
  }



}