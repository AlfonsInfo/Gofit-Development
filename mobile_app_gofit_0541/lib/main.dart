//*Dependency
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/AppBlocObserver.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/changepw_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_instruktur.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_member.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page_pegawai.dart';
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
    appBloc : AppBloc()
  ));
}

//*Global Variable
ThemeConfig themeConfig = ThemeConfig();

class MainApp extends StatelessWidget {
  final AppBloc appBloc;
  const MainApp({super.key, required this.appBloc });

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (context, constraints){
        return MaterialApp(
          debugShowCheckedModeBanner: false,
          // theme: themeConfig.themeLight,
          //* Theme
          theme: themeConfig.themeLight,
          // darkTheme: themeConfig.themeDark,
          home : BlocProvider<AppBloc>(
            create: (context) => appBloc ,
            child: const LoginPage()),
          routes: {
            '/login' : (context) => const LoginPage(),
            '/homeMember' : (context) => const HomePageMember(),
            '/homePegawai' : (context) => const HomePagePegawai(),
            '/homeInstruktur' : (context) => const HomePageInstruktur(),
            '/changepw' : (context) => const ChangePasswordPage()
          },
      );
      },
    );
  }
}