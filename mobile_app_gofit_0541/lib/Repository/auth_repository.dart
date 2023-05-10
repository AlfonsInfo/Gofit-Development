
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';

class AuthRepository {
  Future<LoginResult?> login({required String username, required String password}) async {
    String apiURL = 'http://192.168.1.32:5000/api/login-mobile'; 
    // membuat header dengan 'Content-Type: application/json'
    // Map<String, String> headers = {'Content-Type': 'application/json'};
    
    try{
    var apiResult = await http.post(Uri.parse(apiURL), body:{'username': username, 'password': password },);
    print(apiResult.body);
    var jsonObject = json.decode(apiResult.body);
    print('proses login sukses');
    return LoginResult.createLoginResult(jsonObject);
    }catch(e){
      // ignore: avoid_print
      print(e.toString());
      return null;
    }
  }
}



