
import 'package:http/http.dart' as http;
import 'dart:convert';

class AuthRepository {
  Future<LoginResult?> login({required String username, required String password}) async {
    String apiURL = 'http://127.0.0.1:8000/api/login'; 
    try{
    var apiResult = await http.post(Uri.parse(apiURL), body:{'username': username, 'password': password });
    var jsonObject = jsonDecode(apiResult.body);
    print('proses login sukses');
    return LoginResult.createLoginResult(jsonObject);
    }catch(e){
      // ignore: avoid_print
      print(e.toString());
      return null;
    }
  }
}


//* Template Response dari API
class LoginResult
{
  String message;
  String accessToken;
  String user;
  String pegawai;

  //* Constructor
  LoginResult({required this.message,required this.accessToken, required this.user, required this.pegawai});

  //* Factory Method
  factory LoginResult.createLoginResult(Map<String, dynamic> object){
    return LoginResult(
      message: object['message'], 
      accessToken: object['access_token'],
      user : object['user']['id_pengguna'].toString(),
      pegawai : object ['pegawai']['id_pegawai'].toString(),
      /*dst*/);
  }
}
