
import 'dart:developer';

import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';

class AuthRepository {
  Future<LoginResult?> login({required String username, required String password}) async {
    String apiURL = '$url/login-mobile'; 
    try{
      var apiResult = await http.post(Uri.parse(apiURL), body:{'username': username, 'password': password },);
        if(apiResult.statusCode == 200){
          var jsonObject = json.decode(apiResult.body);
          return LoginResult.createLoginResult(jsonObject);
        }
    }catch(e){
      return null;
    }
  }
}



