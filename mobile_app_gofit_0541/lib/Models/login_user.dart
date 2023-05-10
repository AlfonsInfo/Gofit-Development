//* Template Response dari API
class LoginResult
{
  String? message;
  String? accessToken;
  String? user;
  String? pegawai;
  String? member;
  String? instruktur;

  //* Constructor
  LoginResult({required this.message,required this.accessToken, required this.user, this.pegawai, this.member, this.instruktur});

  //* Factory Method 
  factory LoginResult.createLoginResult(Map<String, dynamic> object){
    try{

    if (object['pegawai'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user: object['user']['id_pengguna'].toString(),
        pegawai: object ['pegawai']['id_pegawai'].toString(),
      );
    } else if (object['member'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user: object['user']['id_pengguna'].toString(),
        member: object ['member']['id_member'].toString(),
      );
    } else if (object['instruktur'] !=   null) {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user: object['user']['id_pengguna'].toString(),
        instruktur: object ['instruktur']['id_instruktur'].toString(),
      );
    } else {
      return LoginResult(
        message: object['message'], 
        accessToken: object['access_token'],
        user : object['user']['id_pengguna'].toString(),
      );
    }
    }catch(e){
      print(e);
    }
    }
}

