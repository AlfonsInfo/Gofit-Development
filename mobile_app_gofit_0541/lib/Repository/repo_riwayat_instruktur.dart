
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


      Future<List<RiwayatInstruktur>> showHistoryInstruktur(String idInstruktur ) async {
  String apiUrl = '$url/riwayataktivitasinstruktur?id_instruktur=$idInstruktur';
    List<RiwayatInstruktur> data =  [];
    try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        inspect(apiResult);
        var jsonObject = json.decode(apiResult.body);
          for(var item in jsonObject['data']){
            data.add(RiwayatInstruktur.fromJson(item));
          }
          inspect(data);
        return data;
    }catch(e){  
        inspect(e);
        return data;
    }
  }




}