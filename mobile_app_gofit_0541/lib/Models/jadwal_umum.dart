
class JadwalUmum{
  String? idJadwalUmum;
  String? hari;
  String? kelas;
  String? jamMulai;
  String? jamSelesai;

  JadwalUmum({required this.idJadwalUmum, required this.hari , required this.kelas ,required  this.jamMulai ,required  this.jamSelesai});

  factory JadwalUmum.fromJson(Map<String, dynamic> json){
    return JadwalUmum(
      idJadwalUmum: json['id_jadwal_umum'].toString(),
      hari: json['hari'].toString(), 
      kelas: json['id_kelas'].toString(), 
      jamMulai: json['jam_mulai'].toString(), 
      jamSelesai: json['jam_selesai'].toString(), 
      // noTelp: json['no_telp'].toString()
      );
  }
}
