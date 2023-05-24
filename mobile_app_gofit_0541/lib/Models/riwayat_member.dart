class RiwayatMember{
  String? idRiwayat;
  String? idMember;
  String? tanggal;
  String? namaAktivitas;
  String? noStruk;
  String? noBooking;

  RiwayatMember({required this.idRiwayat, this.idMember, this.tanggal, this.noStruk, this.noBooking,this.namaAktivitas});

  factory RiwayatMember.fromJson(Map<String, dynamic> json){
    return RiwayatMember(
      idRiwayat: json['id_riwayat'].toString(),
      idMember: json['id_member'].toString(),
      tanggal: json['tanggal'].toString(),
      noBooking: json['no_booking'].toString(),
      noStruk: json['no_struk'].toString(),
      namaAktivitas: json['nama_aktivitas'].toString()
    );
  }
  
}