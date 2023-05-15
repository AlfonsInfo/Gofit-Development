
import 'package:mobile_app_gofit_0541/Models/newModels/pengguna.dart';

class Instruktur{
  // Pengguna? pengguna;
  String? idInstruktur;
  String? nama;
  String? tglLahir;
  String? alamat;
  String? noTelp;

  Instruktur({/*required this.penggu  na,*/ required this.idInstruktur , required this.nama ,required  this.tglLahir ,required  this.alamat,required  this.noTelp});

  factory Instruktur.fromJson(Map<String, dynamic> json){
    return Instruktur(
      // json['id_pengguna'].toString(),
      // pengguna: penggun,
      idInstruktur: json['id_instruktur'].toString(), 
      nama: json['nama_instruktur'].toString(), 
      tglLahir: json['tanggal_lahir_instruktur'].toString(), 
      alamat: json['alamat_instruktur'].toString(), 
      noTelp: json['no_telp'].toString()
      );
  }
}


// //             "id_instruktur": "ins-16",
//             "id_pengguna": 142,
//             "nama_instruktur": "test",
//             "tanggal_lahir_instruktur": "2023-05-27 00:00:00",
//             "alamat_instruktur": "padang",
//             "no_telp_instruktur": "019301",