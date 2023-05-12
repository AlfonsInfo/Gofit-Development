//*Dependency
import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Config/global.dart';
//* Page
import 'Pages/Auth/login_page.dart';
//* Theme
import 'Config/theme_config.dart';

//*State
import 'Bloc/app/app_bloc.dart';
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
    return MultiBlocProvider(
      providers: [
        BlocProvider(create: (context) => AppBloc(),),
      ],
      child: LayoutBuilder(
        builder: (context, constraints){
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            //* Theme
            theme: themeConfig.themeLight,
            // darkTheme: themeConfig.themeDark,
          home :const LoginPage(),
            routes: routesApp,
        );
        },
      ),
    );
  }
}