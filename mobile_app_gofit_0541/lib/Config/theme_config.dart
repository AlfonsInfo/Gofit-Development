import 'package:flutter/material.dart';

class ColorApp{
  static const colorPrimary = Color(0xFF6C0604);
  static const colorButtonPrimary = Color(0xFFFF1445);
}

class ThemeConfig  {
  
  ThemeData themeLight = ThemeData(
            //* AppBar
            appBarTheme: const AppBarTheme(
              backgroundColor: ColorApp.colorPrimary
            ),
            //* Elevated Button
            elevatedButtonTheme: const ElevatedButtonThemeData(
              style: ButtonStyle(
                backgroundColor: MaterialStatePropertyAll(ColorApp.colorButtonPrimary),
              )
            ),
            //* Input Field & Icon
            inputDecorationTheme: const InputDecorationTheme(
              iconColor: ColorApp.colorPrimary,
              fillColor: Colors.white,              
            ),
          );

}