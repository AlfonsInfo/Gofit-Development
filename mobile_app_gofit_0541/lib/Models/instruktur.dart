


class Instruktur{
  String? idPengguna;
  String? idInstruktur;
  String? nama;
  String? tglLahir;
  String? alamat;
  String? noTelp;

  Instruktur({required this.idPengguna, required this.idInstruktur , required this.nama ,required  this.tglLahir ,required  this.alamat,required  this.noTelp});

  factory Instruktur.fromJson(Map<String, dynamic> json){
    return Instruktur(
      idPengguna: json['id_pengguna'].toString(),
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