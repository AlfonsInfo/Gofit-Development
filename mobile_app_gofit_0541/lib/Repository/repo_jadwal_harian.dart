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

  Future<List<JadwalHarian>> getTodayClasses() async{
    String apiURL = '$url/todayclasses';
    try{
      var result = await http.get(Uri.parse(apiURL));
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
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

    Future<List> mulaiKelas(String id) async {
      String apiUrl = '$url/updatemulai/$id';
      try{
        var apiResult = await http.put(Uri.parse(apiUrl), );
        inspect(apiResult);
        var jsonObject = json.decode(apiResult.body);
        final responseData = jsonDecode(apiResult.body);
        final responseMessage = responseData['message'];
        if(apiResult.statusCode == 200){
          return [responseMessage,true];
        }else if(apiResult.statusCode == 400){
          return [responseMessage,false];
        }else{
          return ['Gagal Membatalkan Booking',false];
        }
    }catch(e){
        inspect(e);
        return ['Gagal'];
    }
    }  

    Future<List> selesaiKelas(String id) async {
      String apiUrl = '$url/updateselesai/$id';
      try{
        var apiResult = await http.put(Uri.parse(apiUrl), );
        inspect(apiResult);
        var jsonObject = json.decode(apiResult.body);
        final responseData = jsonDecode(apiResult.body);
        final responseMessage = responseData['message'];
        if(apiResult.statusCode == 200){
          return [responseMessage,true];
        }else if(apiResult.statusCode == 400){
          return [responseMessage,false];
        }else{
          return ['Gagal Membatalkan Booking',false];
        }
    }catch(e){
        inspect(e);
        return ['Gagal'];
    }
    }


    //
     Future<List<JadwalHarian>> getTodayClassesInstructure(String idInstruktur) async{
    String apiURL = '$url/todayclassesinstructure/$idInstruktur';
    try{
      var result = await http.get(Uri.parse(apiURL));
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
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
 
 