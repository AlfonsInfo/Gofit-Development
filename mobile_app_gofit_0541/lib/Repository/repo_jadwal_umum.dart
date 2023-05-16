import 'dart:developer';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';


class JadwalUmumRepository{

  Future<List<JadwalUmum>> getJadwalByInstruktur(idInstruktur) async{
    String apiURL = '$url/jadwalbyinstruktur';
    try{
      var result = await http.post(Uri.parse(apiURL),body:  {'id_instruktur' :  idInstruktur});
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
 
 