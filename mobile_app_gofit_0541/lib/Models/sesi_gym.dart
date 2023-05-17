
class Sesi{
  String? idSesi;
  String? waktuMulai;
  String? waktuSelesai;
  
  Sesi({this.idSesi, this.waktuMulai, this.waktuSelesai});

  factory Sesi.fromJson(Map<String,dynamic> json){
    return Sesi(
      idSesi:json['id_sesi']?.toString() ?? '', 
      waktuMulai:json['waktu_mulai']?.toString() ?? '', 
      waktuSelesai:json['waktu_selesai']?.toString() ?? '' 
      );
  }


  
  // factory Pegawai.fromJson(Map<String,dynamic> json){
  //   return Pegawai(
  //     idPegawai: json['id_pegawai']?.toString() ?? '',
  //     idPengguna: json['id_pengguna']?.toString() ?? '',
  //     namaPegawai: json['nama_pegawai']?.toString() ?? '',
  //     jabatanPegawai : json['jabatan_pegawai']?.toString() ?? '',
  //     tglLahir: json['tgl_lahir_pegawai']?.toString() ?? '',
  //     noTelp: json['no_telp_pegawai']?.toString() ?? '',
  //     alamatPegawai: json['alamat_pegawai']?.toString() ?? '',
  //   );
  // }
}
