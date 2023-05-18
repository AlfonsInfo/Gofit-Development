
import 'dart:developer';


class Kelas{
  String? idKelas;
  String? jenisKelas;
  String? hargaKelas;
  String? deskripsiKelas;

  Kelas({required this.idKelas, this.jenisKelas, this.hargaKelas, this.deskripsiKelas});

  factory Kelas.fromJson(Map<String, dynamic> json){
    return Kelas(
      idKelas: json['id_kelas'].toString(),
      jenisKelas: json['jenis_kelas'].toString(),
      hargaKelas: json['harga_kelas'].toString(),
      deskripsiKelas: json['deskripsi_kelas'].toString()
    );
  }


}


// class Instruktur{
//   String? idPengguna;
//   String? idInstruktur;
//   String? nama;
//   String? tglLahir;
//   String? alamat;
//   String? noTelp;

//   Instruktur({required this.idPengguna, required this.idInstruktur , required this.nama ,required  this.tglLahir ,required  this.alamat,required  this.noTelp});

//   factory Instruktur.fromJson(Map<String, dynamic> json){
//     return Instruktur(
//       idPengguna: json['id_pengguna'].toString(),
//       idInstruktur: json['id_instruktur'].toString(), 
//       nama: json['nama_instruktur'].toString(), 
//       tglLahir: json['tanggal_lahir_instruktur'].toString(), 
//       alamat: json['alamat_instruktur'].toString(), 
//       noTelp: json['no_telp'].toString()
//       );
//   }
// }
