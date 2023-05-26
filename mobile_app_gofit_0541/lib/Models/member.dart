import 'kelas.dart';

class Member{
  String? idMember;
  String? idPengguna;
  String? namaMember;
  String? tglLahirMember;
  String? noTelpMember;
  String? alamatMember;
  String? tglKadeluarsaAktivasi;
  String? totalDepositUang;
  String? tglGabung;
  String? totalDepositPaket;
  String? tglKadeluarsaPaket;
  Kelas? kelas;

  Member({
    this.idMember,
    this.idPengguna,
    this.namaMember,
    this.tglLahirMember,
    this.noTelpMember,
    this.alamatMember,
    this.tglKadeluarsaAktivasi,
    this.totalDepositUang,
    this.tglGabung,
    this.totalDepositPaket,
    this.tglKadeluarsaPaket,
    this.kelas
  });
  
  factory Member.fromJson(Map<String,dynamic> json){
    return Member(
      idMember: json['id_member']?.toString() ?? '',
      idPengguna: json['id_pengguna']?.toString() ?? '',
      namaMember: json['nama_member']?.toString() ?? '',
      tglLahirMember: json['tgl_lahir_member']?.toString() ?? '',
      noTelpMember: json['no_telp_member']?.toString() ?? '',
      alamatMember: json['alamat_member']?.toString() ?? '',
      tglKadeluarsaAktivasi: json['tgl_kadeluarsa_aktivasi']?.toString() ?? '',
      totalDepositUang: json['total_deposit_uang']?.toString() ?? '',
      tglGabung: json['tgl_gabung_member']?.toString() ?? '',
      totalDepositPaket: json['total_deposit_paket']?.toString() ?? '',
      tglKadeluarsaPaket: json['tgl_kadeluarsa_paket']?.toString() ?? '',
    kelas: (json['kelas'] != null) ? Kelas.fromJson(json['kelas']) : null
    );
  }
}



        //*Response
        // "id_member": "23.05.042",
        // "id_pengguna": 146,
        // "namaMember": "mamang",
        // "tgl_lahir_member": "2002-05-21 00:00:00",
        // "no_telp_member": "0821723723",
        // "alamatMember": "padanggg",
        // "tglKadeluarsaAktivasi": null,
        // "total_deposit_uangtotalDepositUang 0,
        // "tgl_gabung_member": "2023-05-11 tglGabung09:32",
        // "total_deposit_paket": 0,
        // totalDepositPaket "tgl_kadeluarsa_paket": null,
        // "created_at": "tgl_kadeluarsa_paket-05-10T20:09:32.000000Z",
        // "updated_at": "2023-05-10T20:09:32.000000Z",
        // "deleted_at": null