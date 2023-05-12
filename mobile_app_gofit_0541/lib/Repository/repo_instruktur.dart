
import 'dart:developer';

import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:mobile_app_gofit_0541/Models/pegawai.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';

class InstrukturRepository {
  Future<List<Instruktur>> getInstruktur() async {
    String apiURL = '$url/instruktur'; 
    try{
      var apiResult = await http.get(Uri.parse(apiURL));
      if(apiResult.statusCode == 200){
        var jsonObject = json.decode(apiResult.body);
        List<Instruktur> instrukturs = [];
        for (var item in jsonObject['data']) {
          instrukturs.add(Instruktur.fromJson(item));
        }
        // inspect(instrukturs);
        return instrukturs;
      }
    }catch(e){
      return [];
    }
    return [];
  }


  Future<List<JadwalUmum>> getJadwalByInstruktur(idInstruktur) async{
    String apiURL = '$url/jadwalbyinstruktur';
    try{
      var result = await http.post(Uri.parse(apiURL),body:  {'id_instruktur' :  'ins-9'});
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
        inspect(jsonObject);
        List<JadwalUmum> jadwalUmums = [];
        for (var item in jsonObject['data']) {
          jadwalUmums.add(JadwalUmum.fromJson(item));
        }
        inspect(jadwalUmums);
        return jadwalUmums;
      }
    }catch(e){
      return [];
    }
    return [];
  }
}


