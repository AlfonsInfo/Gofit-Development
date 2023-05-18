//* Import
import 'dart:developer';
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:http/http.dart' as http;
import 'package:mobile_app_gofit_0541/Models/kelas.dart';

class KelasRepository{

    Future<List<Kelas>> show() async {
      String apiUrl = '$url/kelas';
      List<Kelas> data =  [];
      try{
        var apiResult = await http.get(Uri.parse(apiUrl));
        var jsonObject = json.decode(apiResult.body);

          for(var item in jsonObject['kelas']){
            data.add(Kelas.fromJson(item));
          }
        return data;
    }catch(e){
        inspect(e);
        return data;
    }
    }  
}