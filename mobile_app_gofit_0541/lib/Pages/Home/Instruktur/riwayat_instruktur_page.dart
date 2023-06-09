import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/riwayat_instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/riwayat_member.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_riwayat_instruktur.dart';


class RiwayatInstrukturPage extends StatefulWidget {
  const RiwayatInstrukturPage({super.key});

  @override
  State<RiwayatInstrukturPage> createState() => _RiwayatInstrukturPageState();
}

class _RiwayatInstrukturPageState extends State<RiwayatInstrukturPage> {
  List<RiwayatInstruktur> riwayats =  [];
  RiwayatInstrukturRepository riwayatInstrukturRepository = RiwayatInstrukturRepository();

  @override
  void initState() {
    super.initState();
    getRiwayat2();

  }

  getRiwayat2() async{
    var appBloc = context.read<AppBloc>();
    var idInstruktur =  appBloc.state.instruktur?.idInstruktur ;
    riwayats = await riwayatInstrukturRepository.showHistoryInstruktur(idInstruktur ?? '');
    inspect(riwayats);
    setState(() {});
  }
  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('History Activity'),
      body: ListView.builder(
        itemCount: riwayats.length,
        itemBuilder: (context, index) => activityUnit(riwayats[index]),
      ),
    );
  }

Widget activityUnit(RiwayatInstruktur rm) {
  return Builder(
    builder: (BuildContext context) {
      return unitRiwayatInstruktur(rm);
    },
  );
}

Card unitRiwayatInstruktur(RiwayatInstruktur rm){
    const textStyle = TextStyle(color: Colors.white);
    const textStyle2 = TextStyle(color: Colors.white, backgroundColor: Color.fromARGB(255, 0, 0, 0));
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image1.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment.topCenter,
            ),
          ),
          child:  ListTile(
            title: Text('#${rm.jenisKelas} ' ,style: textStyle,),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                lineDetail('Class Date : ${rm.hari}, ${rm.tanggalJadwalHarian}', textStyle, Icons.calendar_month),
                lineDetail('Start time ${rm.jamMulai} - End time ${rm.jamSelesai}', textStyle, Icons.watch_later_outlined),
                lineDetail('Rp ${rm.hargaKelas}', textStyle, Icons.money),
                lineDetail('${rm.jumlahPeserta} of 10' ,textStyle, Icons.person),
                (rm.jamMulaiSebenarnya != '') ? Text('Kelas dimulai : ${rm.jamMulaiSebenarnya} dan berakhir ${rm.jamSelesaiSebenarnya}') : SizedBox.shrink()
              ],
            ),
          ),
        ),
      );  
}



Widget lineDetail(String text, TextStyle textStyle, IconData ic) {
  return Padding(
    padding: const EdgeInsets.all(3.0),
    child: Row(
                  children: [
                    Icon(ic,color: Colors.white,),
                    const SizedBox(width: 10,),
                    Text(text,style: textStyle,)
                  ],
                ),
  );
}

}