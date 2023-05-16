import 'dart:developer';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';


class JadwalHarianRepository{

  Future<List<JadwalHarian>> getJadwalByInstruktur(idInstruktur) async{
    String apiURL = '$url/jadwalbyinstruktur';
    try{
      var result = await http.post(Uri.parse(apiURL),body:  {'id_instruktur' :  idInstruktur});
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
        inspect(jsonObject);
        List<JadwalHarian> jadwalHarians = [];
        for (var item in jsonObject['data']) {
          jadwalHarians.add(JadwalHarian.fromJson(item));
        }
        return jadwalHarians;
      }
    }catch(e){
      return [];
    }
    return [];
  }
  }
 
 