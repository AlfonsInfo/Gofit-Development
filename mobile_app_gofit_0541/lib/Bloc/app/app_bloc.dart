//* Digunakan untuk state secara keseluruhan
// import 'dart:developer';
import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Models/member.dart';
import 'package:mobile_app_gofit_0541/Models/pegawai.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';

part 'app_event.dart';
part 'app_state.dart';

class AppBloc extends Bloc<AppEvent, AppState>{

  AppBloc() : super(AppState(user: User(idPengguna: '', username: '', role: ''))){
    on<SaveUserInfo>(_saveUserInfo);
    on<SaveSelectedKelas>(_saveSelectedKelas);
  }

  _saveUserInfo(SaveUserInfo event, Emitter<AppState> emit){
    emit(state.copyWith(user: event.user, instruktur: event.instruktur, member: event.member , pegawai: event.pegawai));
  }

  _saveSelectedKelas(SaveSelectedKelas event, Emitter<AppState> emit){
    emit(state.copyWith(jadwalHarian: event.jadwalHarian));
    // inspect(state.jadwalHarian);
  }
}