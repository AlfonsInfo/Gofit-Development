
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/riwayat_instruktur.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class RiwayatInstrukturRepository{

  Future<List<RiwayatInstruktur>> getInstrukturHistory(idInstruktur) async{
    String apiURL = '$url/riwayataktivitasinstrukturmerge?id_instruktur=$idInstruktur';
    // inspect(apiURL);
    try{
      var result = await http.get(Uri.parse(apiURL));
      // inspect(result);
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
        List<RiwayatInstruktur> riwayats = [];
        for (var item in jsonObject['data']) {
          riwayats.add(RiwayatInstruktur.fromJson(item));
        }
        return riwayats;
      }
    }catch(e){
      return [];
    }
    return [];
  }


}