

import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_jadwal_harian.dart';

//* HomePageInstruktur
class HomePageInstruktur extends StatefulWidget {
  const HomePageInstruktur({super.key});

  @override
  State<HomePageInstruktur> createState() => _HomePageInstrukturState();
}

class _HomePageInstrukturState extends State<HomePageInstruktur> {
  List<JadwalHarian> todayClasses  = [];
  JadwalHarianRepository jadwalHarianRepository = JadwalHarianRepository();

  @override
  initState(){
    super.initState();
    getTodayClasses();
  }

  getTodayClasses() async{
      var appBloc = context.read<AppBloc>();
    var idInstruktur= appBloc.state.instruktur?.idInstruktur;
    todayClasses = await jadwalHarianRepository.getTodayClassesInstructure(idInstruktur ?? '');
    setState(() {});
  }


  @override
  Widget build(BuildContext context) {
  final widthBox = MediaQuery.of(context).size.width * 0.9;
  final heightBox = MediaQuery.of(context).size.height * 0.3;
    return  Scaffold(
      appBar: createAppBar('Welcome Instructure'), 
      //* UTAMA
      body: Column( 
        children:
        [
        const HeaderTemplate(message: 'Selamat Datang Instruktur',),
        menuInstruktur(context,widthBox, heightBox),
        HeaderTemplate(message: 'Kelas Anda Hari ini'),
        Expanded(child: ListView.builder(
          itemCount: todayClasses.length,
          itemBuilder: (context, index) => classCard(todayClasses[index]),
          )
        )
        // BlocBuilder<AppBloc, AppState>(
        // builder: (context, state) {
            // return Text('Username: ${state.user?.username ?? ""}');
        // })
        ]
      ),
      //*Akhir dari UtamaSW
      drawer: const SideBar(alamatRoute: '/profileinstruktur'),
    );
  }

  Center menuInstruktur(context,double widthBox, double heightBox) {
    return Center(
        child: Container(
          width: widthBox,
          height: heightBox,  
          decoration: BoxDecoration(
            border: Border.all(
              color: ColorApp.colorPrimary,
              width: 4,
              style: BorderStyle.solid,
            ),
            borderRadius: BorderRadius.circular(10.0),
          ),
          child: Padding(
            padding: const EdgeInsets.all(20.0),
            child: Row(
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    children:  [
                      IconButton(onPressed: (){
                        Navigator.pushNamed(context, '/ijin');
                      }, icon: const Icon(Icons.mail),tooltip: 'Ijin',),
                      const Text('Ijin'),
                      
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    children: [
                      IconButton(onPressed: (){
                        Navigator.pushNamed(context, '/riwayatijin');
                      }, icon: const Icon(Icons.history),tooltip: 'Izin Instruktur',),
                      const Text('Riwayat Ijin'),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    children: [
                      IconButton(onPressed: (){}, icon: const Icon(Icons.check_box_outlined),tooltip: 'Izin Instruktur',),
                      const Text('Presensi Kelas')
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      );
  }

  //* Card Today Classes Instruktur
    Widget classCard(JadwalHarian jd) {
    var boldStyle = TextStyle(fontWeight: FontWeight.bold);
    return BlocBuilder<AppBloc,AppState>(
      builder: (context,state) {
        return Padding(
          padding: const EdgeInsets.all(4.0),
          child: Card(
              child: ListTile(
              title: Text(jd.jadwalUmum!.kelas!.jenisKelas ?? '', style: boldStyle,),
                subtitle:
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children : const [
                    Text('tap to enter')
                    // (jd.ijinInstruktur == null) ? 
                      // Text('Instruktur : ${jd.jadwalUmum!.instruktur!.nama} - Sesi : ${jd.jadwalUmum!.jamMulai} - ${jd.jadwalUmum!.jamSelesai }') 
                      // : 
                      // Text('Instruktur : ${jd.ijinInstruktur!.instrukturPengganti!} - Sesi : ${jd.jadwalUmum!.jamMulai} - ${jd.jadwalUmum!.jamSelesai }'),
                    // if (jd.jamMulai != null && jd.jamSelesai != null) completed() else if(jd.jamMulai != null) onGoing() else  SizedBox.shrink()
                  ],
                ),
                onTap: (){
                  context.read<AppBloc>().add(SaveSelectedKelas(jadwalHarian: jd));
                  Navigator.pushNamed(context, '/absenKelas');
                },
              // trailing: PopUpActions(),
              isThreeLine: true,
              leading: Icon(Icons.sports_gymnastics_outlined),
              ),
            ),
        );
      }
    );
  }
}