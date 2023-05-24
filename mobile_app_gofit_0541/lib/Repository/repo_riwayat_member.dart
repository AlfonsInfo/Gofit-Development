
import 'dart:developer';

import 'package:mobile_app_gofit_0541/Models/riwayat_member.dart';
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


}