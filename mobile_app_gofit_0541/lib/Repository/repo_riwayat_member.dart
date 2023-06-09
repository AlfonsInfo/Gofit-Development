
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/booking_kelas.dart';
import 'package:mobile_app_gofit_0541/Models/riwayat_member.dart';
import 'package:mobile_app_gofit_0541/Models/booking_gym.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class RiwayatMemberRepository{

  Future<List<RiwayatMember>> getMemberHistory(idMember) async{
    String apiURL = '$url/riwayataktivitasmember?id_member=$idMember';
    try{
      var result = await http.get(Uri.parse(apiURL));
      inspect(result);
      if(result.statusCode == 200){
        var jsonObject = json.decode(result.body);
        List<RiwayatMember> riwayats = [];
        for (var item in jsonObject['data']) {
          riwayats.add(RiwayatMember.fromJson(item));
        }
        return riwayats;
      }
    }catch(e){
      return [];
    }
    return [];
  }


  Future<List<BookingGym>> showHistoryGym(String idMember) async {
  String apiUrl = '$url/riwayataktivitasmembergym?id_member=$idMember';
    List<BookingGym> data =  [];
    try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        var jsonObject = json.decode(apiResult.body);
          for(var item in jsonObject['data']){
            data.add(BookingGym.fromJson(item));
          }
          inspect(data);
        return data;
    }catch(e){
        inspect(e);
        return data;
    }
  }
  
  //* Show history kelas 
  Future<List<BookingKelas>> showHistoryKelas(String idMember) async {
  String apiUrl = '$url/riwayataktivitasmemberkelas?id_member=$idMember';
    List<BookingKelas> data =  [];
    try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        inspect(apiResult);
        var jsonObject = json.decode(apiResult.body);
          for(var item in jsonObject['data']){
            data.add(BookingKelas.fromJson(item));
          }
          inspect(data);
        return data;
    }catch(e){  
        inspect(e);
        return data;
    }
  }  



  Future<List<BookingGym>> showHistoryGymFilter(String idMember,String tanggal_mulai, String tanggal_selesai) async {
  String apiUrl = '$url/riwayataktivitasmembergymfilter?id_member=$idMember&tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai';
    List<BookingGym> data =  [];
    try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        var jsonObject = json.decode(apiResult.body);
          for(var item in jsonObject['data']){
            data.add(BookingGym.fromJson(item));
          }
          inspect(data);
        return data;
    }catch(e){
        inspect(e);
        return data;
    }
  }


    Future<List<BookingKelas>> showHistoryKelasFilter(String idMember ,String tanggal_mulai, String tanggal_selesai ) async {
  String apiUrl = '$url/riwayataktivitasmemberkelasfilter?id_member=$idMember&tanggal_mulai=$tanggal_mulai&tanggal_selesai=$tanggal_selesai';
    List<BookingKelas> data =  [];
    try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        inspect(apiResult);
        var jsonObject = json.decode(apiResult.body);
          for(var item in jsonObject['data']){
            data.add(BookingKelas.fromJson(item));
          }
          inspect(data);
        return data;
    }catch(e){  
        inspect(e);
        return data;
    }
  }  

}