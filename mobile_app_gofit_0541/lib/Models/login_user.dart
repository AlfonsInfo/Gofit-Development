import 'package:http/http.dart' as http;
import 'dart:convert';
class LoginResult
{
  String message;

  //* Constructor
  LoginResult({required this.message});

  //* Factory Method
  factory LoginResult.createLoginResult(Map<String, dynamic> object){
    return LoginResult(message: object['message'], /*dst*/);
  }

  //* Penghubung ke API
  //* login / login-mobile
  static Future<LoginResult?>connectToAPI(String username, String password) async {
    String apiURL = 'http://127.0.0.1:8000/api/login'; 
    try{
    var apiResult = await http.post(Uri.parse(apiURL), body:{'username': username, 'password': password });
    var jsonObject = jsonDecode(apiResult.body);
    return LoginResult.createLoginResult(jsonObject);
    } catch(e){
      // ignore: avoid_print
      print(e.toString());
      return null;
    }
  }
}