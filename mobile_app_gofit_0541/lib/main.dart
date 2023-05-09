//*Dependency
import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/StateBlocTemplate/Home/login_bloc.dart';

//* Page
import 'Pages/login_page.dart';

//* Theme
import 'Config/theme_config.dart';

//* State Management
import 'package:flutter_bloc/flutter_bloc.dart';


//* Starter App
void main(){
  //* Setup Window (Platform & Ukurannya)
  //* Run App
  runApp(const MainApp());
}

//*Global Variable
ThemeConfig themeConfig = ThemeConfig();

class MainApp extends StatelessWidget {
  const MainApp({super.key});

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
          home : BlocProvider(
            create: (_) => LoginBloc(),
            child: const LoginPage(),
          ),
      );
      },
    );
  }
}