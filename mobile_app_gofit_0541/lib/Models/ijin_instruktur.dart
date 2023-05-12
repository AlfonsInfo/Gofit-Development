class IjinInstruktur{
  String? idIjin;
  String? idJadwalHarian;
  String? statusIjin;
  String? tanggalPengajuan;
  String? instrukturPengganti;

  IjinInstruktur({this.idIjin, this.idJadwalHarian, this.tanggalPengajuan, this.instrukturPengganti , this.statusIjin});

  factory IjinInstruktur.fromJson(Map<String, dynamic> json){
    return IjinInstruktur(
      idIjin: json['id_instruktur'].toString(),
      idJadwalHarian: json['id_jadwal_harian'].toString(), 
      tanggalPengajuan: json['tanggal_pengajuan'].toString(), 
      statusIjin: json['status_ijin'],
      instrukturPengganti: json['id_instruktur_pengganti'].toString(), 
      );
  }
  
}