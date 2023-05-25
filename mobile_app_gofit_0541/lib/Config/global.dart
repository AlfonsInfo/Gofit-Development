import 'package:mobile_app_gofit_0541/Pages/Auth/login_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/izin/izin_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/riwayat_instruktur_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/profile_member.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/riwayat_member_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Pegawai/profile_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/profile_instruktur_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/changepw_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/home_page_instruktur.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/home_page_member.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/member_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Pegawai/home_page_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/riwayat_ijin.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/absen_kelas_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Public/public_jadwal_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Public/public_pricelist_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Public/public_menjelajah.page.dart';



//* Setingan Routes
var routesApp = {
  //* Login Page
  '/login' : (context) => const LoginPage(),
  // '/homeMember' : (context) => const HomePageMember(),
  //* Home
  '/homeMember' : (context) => const MemberPage(),
  '/homePegawai' : (context) => const HomePagePegawai(),
  '/homeInstruktur' : (context) => const HomePageInstruktur(),
  '/changepw' : (context) => const ChangePasswordPage(),
  
  //* Profile
  '/profilePegawai' : (context) => const ProfilePegawai(),
  '/profilemember' : (context) => const ProfileMemberPage(),
  '/profileinstruktur' : (context) => const ProfileInstrukturPage(),
  '/ijin' : (context) => const IjinPages(),
  '/riwayatijin' : (context) => const RiwayatIjinPage(),
  '/absenKelas' : (context) => const AbsenKelasPage(),
  '/jadwalharian' : (context) => const JadwalPage(),
  '/pricelist' : (context) => const  PricelistPage(),
  '/menjelajah' : (context) => const  MenjelajahPage(),

  //* History 
  '/riwayataktivitasmember' : (context) => const  RiwayatMemberPage(),
  '/riwayatinstruktur' : (context) => const  RiwayatInstrukturPage(),
  };

//* Setingan URL
String url = 'http://192.168.149.34:5000/api';
// String url = 'http://10.54.10.247:5000/api';



