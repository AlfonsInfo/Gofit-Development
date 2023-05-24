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
    getRiwayat();

  }


  getRiwayat() async{
    var appBloc = context.read<AppBloc>();
    var idInstruktur =  appBloc.state.instruktur?.idInstruktur ;
    riwayats = await riwayatInstrukturRepository.getInstrukturHistory(idInstruktur ?? '');
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
      if (rm.ijinInstruktur != null) {
        return unitIjin(rm);
      } else if (rm.presensiInstruktur != null){ 
        return unitPresensi(rm);
      }else {
        return const SizedBox.shrink();
      }
    },
  );
}

Card unitIjin(RiwayatInstruktur rm){
    const textStyle = TextStyle(color: Colors.white);
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
            title: Text('Ijin Instruktur - ${rm.ijinInstruktur?.tanggalPengajuan}' ,style: textStyle,),
            subtitle: Text('Nice Move', style: textStyle,),
          ),
        ),
      );  
}
Card unitPresensi(RiwayatInstruktur rm){
    const textStyle = TextStyle(color: Colors.white,backgroundColor: Color.fromARGB(200, 0, 0, 0));
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image4.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment(0, 0),
            ),
          ),
          child:  ListTile(
            title: Text('Presensi ${rm.presensiInstruktur?.jadwalHarian?.tanggal} - ${rm.presensiInstruktur?.jadwalHarian?.jadwalUmum?.kelas?.jenisKelas}' ,style: textStyle,),
            // subtitle: Text('Nice Move', style: textStyle,),
          ),
        ),
      );  
}

Card unitDepositUangActivity(RiwayatMember rm) {
    const textStyle = TextStyle(color: Colors.white,);
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image6.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment.center,
            ),
          ),
          child:  ListTile(
            title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
            subtitle: Text('Nice Move', style: textStyle,),
          ),
        ),
      );  
}

Card unitActivasiActivity(RiwayatMember rm){
    const textStyle = TextStyle(color: Colors.white,);
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image8.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment.bottomCenter,
            ),
          ),
          child:  ListTile(
            title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
            subtitle: Text('Nice Move', style: textStyle,),
          ),
        ),
      );  
}

Card unitRegisterActivity(RiwayatMember rm){
    const textStyle = TextStyle(color: Colors.white,);
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image9.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment.center,
            ),
          ),
          child:  ListTile(
            title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
            subtitle: Text('Nice Move', style: textStyle,),
          ),
        ),
      );  
}
}