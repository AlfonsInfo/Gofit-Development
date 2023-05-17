//* Import
import 'dart:developer';
import 'dart:convert';
import 'package:mobile_app_gofit_0541/Config/global.dart';
import 'package:http/http.dart' as http;

class BookingGymRepository{

    Future<List> store({required String idSesi, required String bookingDate,required String IdMember}) async{
      String apiUrl = '$url/bookinggym';
      try{
        var apiResult = await http.post(Uri.parse(apiUrl), 
        body: 
        {
          'id_member' : IdMember,
          'tanggal_sesi_gym': bookingDate,
          'id_sesi' : idSesi
        });
        //* + validasi di backend
        final responseData = jsonDecode(apiResult.body);
        final responseMessage = responseData['message'];
        if(apiResult.statusCode == 200){
          return [responseMessage,true];
        }else if(apiResult.statusCode == 400){
          return [responseMessage,false];
        }else{
          return ['Gagal Booking',false];
        }
      }catch(e){
        inspect(e);
        return ['Gagal Booking',false];
      }
    }  
}