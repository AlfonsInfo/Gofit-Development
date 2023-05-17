
import 'dart:developer';

import 'package:http/http.dart' as http;
import 'dart:convert';
// import 'package:mobile_app_gofit_0541/Models/login_user.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
// import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';

class SesiRepository {
  Future<List<Sesi>> getSesi() async {
    String apiURL = '$url/sesiGym'; 
    try{
      var apiResult = await http.get(Uri.parse(apiURL));
      if(apiResult.statusCode == 200){
        var jsonObject = json.decode(apiResult.body);
        List<Sesi> sesi = [];
        for (var item in jsonObject['sesiGym']) {
          sesi.add(Sesi.fromJson(item));
        }
        return sesi;
      }
    }catch(e){
      return [];
    }
    return [];
  }

}


