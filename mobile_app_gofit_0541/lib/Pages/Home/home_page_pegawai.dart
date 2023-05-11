import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
// import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Components/component_1.dart';

//* HomePagePegawai
class HomePagePegawai extends StatelessWidget {
  const HomePagePegawai({super.key});

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('Welcome MO'), 
      body:MultiBlocProvider(
        providers: [
          BlocProvider(create: (context) => AppBloc()),
        ],
        child:ListView(
            children: [
            const HeaderTemplate(message: 'Kelas Hari ini'),
            classCard('SPINE Corrector'),        
            classCard('Muaythai'),        
            classCard('BUNGEE'),        
            classCard('Building Up'),        
            classCard('Building Up'),        
            classCard('Building Up'),        
            classCard('Building Up'),
             Center(
        child: BlocBuilder<AppBloc, AppState>(
          builder: (context, state) {
            // inspect(state);
            return Text('Username: ${state.user?.username ?? ""}');
  }
        )
             )
          ],
          ),
      ),      
      drawer: const SideBar()
      );  
  }

  Widget classCard(String title) {
    return Padding(
      padding: const EdgeInsets.all(4.0),
      child: Card(
          child: ListTile(
            leading: const FlutterLogo(size: 72.0),
            title: Text(title),
            subtitle:
                const Text('A sufficiently long subtitle warrants three lines.'),
                trailing:  const Icon(Icons.more_vert),
            isThreeLine: true,
          ),
        ),
    );
  }
}









      // bottomNavigationBar: BottomNavigationBar(
      //   items: const [
      //     BottomNavigationBarItem(
      //       icon: Icon(Icons.sports_gymnastics),
      //       label : 'Kelas'
      //       ),
      //   ]),
