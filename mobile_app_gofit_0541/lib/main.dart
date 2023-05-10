//*Dependency
import 'package:flutter/material.dart';
//* Page
import 'Pages/Auth/login_page.dart';
//* Theme
import 'Config/theme_config.dart';


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
          home : const LoginPage(),
      );
      },
    );
  }
}