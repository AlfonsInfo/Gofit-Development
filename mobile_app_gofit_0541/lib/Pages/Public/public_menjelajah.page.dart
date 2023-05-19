import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';

class MenjelajahPage extends StatelessWidget {
  const MenjelajahPage({super.key});

  @override
  Widget build(BuildContext context) {
    var data = "Gofit merupakan suatu perusahan Sport Studio yang berada di kota Yogyakarta. Sport studio ini memiliki berbagai fasilitas dan alat gym. Sport studio juga menyediakan instruktur dan kelas kebugaran seperti muaythai , swings, taekwondo, dan lain-lain";
    return Scaffold(
      appBar: createAppBar('Jelajah.com'),
      body: Column(
        children :[
        Center(child: HeaderTemplate(message: 'About Gofit')),
        Text('Jl. Centralpark No 10 Yogyakarta'),
        Divider(),
        Padding(
          padding: const EdgeInsets.all(8.0),
          child: Text(data, textAlign: TextAlign.justify,),
        ),
     SizedBox(
      height: MediaQuery.of(context).size.height * 1 / 3,
      child: Image.asset('assets/images/logo-mobile-apps.png'))
        ]
      ),
    );
  }
}