import 'package:mobile_app_gofit_0541/Pages/Auth/login_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/izin/izin_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Pegawai/profile_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/changepw_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/home_page_instruktur.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/home_page_member.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Member/member_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Pegawai/home_page_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/riwayat_ijin.dart';




//* Setingan Routes
var routesApp = {
  '/login' : (context) => const LoginPage(),
  // '/homeMember' : (context) => const HomePageMember(),
  '/homeMember' : (context) => const MemberPage(),
  '/homePegawai' : (context) => const HomePagePegawai(),
  '/homeInstruktur' : (context) => const HomePageInstruktur(),
  '/changepw' : (context) => const ChangePasswordPage(),
  '/profilePegawai' : (context) => const ProfilePegawai(),
  '/ijin' : (context) => const IjinPages(),
  '/riwayatijin' : (context) => const RiwayatIjinPage()
  };

//* Setingan URL
String url = 'http://10.5.2.61:5000/api';
// [
// http://192.168.77.21:5000
// color: ColorApp.colorPrimary,
// 10.113.0.255

