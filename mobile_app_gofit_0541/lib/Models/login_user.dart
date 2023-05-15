//* Template Response dari API
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/pegawai.dart';
import 'package:mobile_app_gofit_0541/Models/user.dart';

class LoginResult
{
  String message;
  String accessToken;
  User user;
  Pegawai? pegawai;
  String? member;
  Instruktur? instruktur;
  //* Constructor
  LoginResult({required this.message,required this.accessToken, required this.user, this.pegawai, this.member, this.instruktur, 
  });

  //* Factory Method 
  factory LoginResult.createLoginResult(Map<String, dynamic> object){
    if (object['pegawai'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user:  User.fromJson(object['user']),
        pegawai: Pegawai.fromJson(object['pegawai']),
      );
    } else if (object['member'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user: User.fromJson(object['user']),
        member: object ['member']['id_member'].toString(),
      );
    } else if (object['instruktur'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user: User.fromJson(object['user']),
        instruktur: Instruktur.fromJson(object['instruktur'])//object ['instruktur']['id_instruktur'].toString(),
      );
    } else {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user : User.fromJson(object['user']),
      );
    }
}

}