import 'package:mobile_app_gofit_0541/Models/izin_instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/presensi_instruktur.dart';

class RiwayatInstruktur{

  //* data baru
  //? yang perlu ditampilin : Hari / Tanggal , Jam Mulai, nama kelas , jumlah peserta kelas
  String? jenisKelas;
  String? hargaKelas;
  String? namaInstruktur;
  String? tanggalJadwalHarian;
  String? hari;
  String? jamMulai;
  String? jamMulaiSebenarnya;
  String? jamSelesai;
  String? jamSelesaiSebenarnya;
  String? jumlahPeserta;
  RiwayatInstruktur({this.jenisKelas, this.hargaKelas, this.namaInstruktur, this.tanggalJadwalHarian, this.hari, this.jamMulai, this.jamSelesai, this.jumlahPeserta, this.jamMulaiSebenarnya, this.jamSelesaiSebenarnya});

  factory RiwayatInstruktur.fromJson(Map<String, dynamic> json){
    return RiwayatInstruktur(
        jenisKelas: json['jenis_kelas'].toString(),
        hargaKelas: json['harga_kelas'].toString(),
        namaInstruktur: json['nama_instruktur'].toString(),
        tanggalJadwalHarian: json['tanggal_jadwal_harian'].toString(),
        hari: json['hari'].toString(),
        jumlahPeserta: json['jumlah_peserta'].toString(),
        jamMulai: json['jam_mulai'].toString(),
        jamSelesai: json['jam_selesai'].toString(),
        jamMulaiSebenarnya: json['jam_mulai_sebenarnya']?.toString() ?? '',
        jamSelesaiSebenarnya: json['jam_selesai_sebenarnya']?.toString() ?? ''
    );
  }
  
}