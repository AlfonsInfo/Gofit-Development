//*Dependency
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/AppBlocObserver.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/izin_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Pegawai/profile_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/changepw_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_instruktur.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_member.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_pegawai.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/Instruktur/riwayat_ijin.dart';
//* Page
import 'Pages/Auth/login_page.dart';
//* Theme
import 'Config/theme_config.dart';

//*State
import 'Bloc/app/app_bloc.dart';

//* Starter App
void main(){
  //* Setup Window (Platform & Ukurannya)
  //* Run App
  Bloc.observer = AppBlocObserver();
  runApp(MainApp(
    // appBloc : AppBloc(),
    // loginBloc : LoginBloc()
  ));
}

//*Global Variable
ThemeConfig themeConfig = ThemeConfig();

class MainApp extends StatelessWidget {
  // final AppBloc appBloc;
  // final LoginBloc loginBloc;
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider(create: (context) => AppBloc(),),
        BlocProvider(create: (context) => LoginBloc(),)                
      ],
      child: LayoutBuilder(
        builder: (context, constraints){
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            // theme: themeConfig.themeLight,
            //* Theme
            theme: themeConfig.themeLight,
            // darkTheme: themeConfig.themeDark,
          home :const LoginPage(),
            routes: {
              '/login' : (context) => const LoginPage(),
              '/homeMember' : (context) => const HomePageMember(),
              '/homePegawai' : (context) => const HomePagePegawai(),
              '/homeInstruktur' : (context) => const HomePageInstruktur(),
              '/changepw' : (context) => const ChangePasswordPage(),
              '/profilePegawai' : (context) => const ProfilePegawai(),
              '/ijin' : (context) => const IjinPages(),
              '/riwayatijin' : (context) => const RiwayatIjinPage()
            },
        );
        },
      ),
    );
  }
}