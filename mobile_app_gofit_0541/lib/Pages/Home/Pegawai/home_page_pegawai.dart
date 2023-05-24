import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Function/function.dart';
// import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_jadwal_harian.dart';



//* HomePagePegawai
class HomePagePegawai extends StatefulWidget {
  const HomePagePegawai({super.key});

  @override
  State<HomePagePegawai> createState() => _HomePagePegawaiState();
}

class _HomePagePegawaiState extends State<HomePagePegawai> {
  List<JadwalHarian> todayClasses  = [];
  JadwalHarianRepository jadwalHarianRepository = JadwalHarianRepository();
  @override
  initState(){
    super.initState();
    getTodayClasses();
  }

  getTodayClasses() async{
    todayClasses = await jadwalHarianRepository.getTodayClasses();
    inspect(todayClasses);
    setState(() {});
  }
  
  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('Welcome MO'), 
      body:Column(
        children : [
        const HeaderTemplate(message: 'Kelas Hari ini'),
        Expanded(
          child: ListView.builder(
            itemCount: todayClasses.length,
            itemBuilder: (context, index) => classCard(todayClasses[index]),
          ),
        )

        ]
      ),      
      drawer: const SideBar(alamatRoute: '/profilePegawai', alamatListRiwayat: ''),
      );  
  }

  Widget classCard(JadwalHarian jd) {
    var boldStyle = const TextStyle(fontWeight: FontWeight.bold);
    return Padding(
      padding: const EdgeInsets.all(4.0),
      child: Card(
          child: ListTile(
          title: Text(jd.jadwalUmum!.kelas!.jenisKelas ?? '', style: boldStyle,),
            subtitle:
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children : [
                (jd.ijinInstruktur == null) ? 
                  Text('Instruktur : ${jd.jadwalUmum!.instruktur!.nama} - Sesi : ${jd.jadwalUmum!.jamMulai} - ${jd.jadwalUmum!.jamSelesai }') : 
                  Text('Instruktur : ${jd.ijinInstruktur!.instrukturPengganti} - Sesi : ${jd.jadwalUmum!.jamMulai} - ${jd.jadwalUmum!.jamSelesai }'),
                  wrapButtonActions(jd),
                if (jd.jamMulai != null && jd.jamSelesai != null) completed() else if(jd.jamMulai != null) onGoing() else  const SizedBox.shrink()
              ],
            ),
          // trailing: PopUpActions(),
          isThreeLine: true,
          leading: const Icon(Icons.sports_gymnastics_outlined),
          ),
        ),
    );
  }

  Card onGoing() {
    return const Card(
                color: Colors.green,
                child: Padding(
                  padding:  EdgeInsets.all(8.0),
                  child: Text('On going',style: TextStyle(color: Colors.white)),
                ), );
  }
  Card completed() {
    return const Card(
        color: Colors.green,
          child: Padding(
            padding:  EdgeInsets.all(8.0),
                child: Text('Completed',style: TextStyle(color: Colors.white)),
      ), );
  }

  Row wrapButtonActions(JadwalHarian jd) {
    var idInstruktur;
    if(jd.ijinInstruktur != null){
      // idInstruktur = jd.ijinInstruktur?.instrukturPengganti.
    }else{
      idInstruktur = jd.jadwalUmum?.instruktur?.idInstruktur;
    }
    void startClassFunction() async {
      var hasil = await jadwalHarianRepository.mulaiKelas(jd.idJadwalHarian ?? '', idInstruktur,jd.idJadwalHarian ?? '' );
      Navigator.pop(context);
      showSnackBarMessage(context, hasil[0]);
      // inspect(hasil);
      getTodayClasses();
    }
    void endClassFunction() async{
      var hasil = await jadwalHarianRepository.selesaiKelas(jd.idJadwalHarian ?? '');
      Navigator.pop(context);
      showSnackBarMessage(context, hasil[0]);
      // inspect(hasil);
      getTodayClasses();
    }

    return Row(
                children: [
                  Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: ElevatedButton(
                      onPressed: (jd.jamMulai != null) ? null : (){
                        showAlertDialog(context, 'Are you sure to start classes now ?', startClassFunction);
                      }, 
                      child: const Text('Start Class')),
                  ),
                  ElevatedButton(
                    onPressed: (jd.jamSelesai == null && jd.jamMulai != null) ? (){
                        showAlertDialog(context, 'Are you sure to end classes now ?', endClassFunction);
                    } : null,
                    child: const Text('End Class')),
                ],
              );
  }


  
}




//* Tidak dipake keknya 
// enum Actions { mulaiKelas, selesaiKelas}
class PopUpActions extends StatefulWidget {
  const PopUpActions({super.key});

  @override
  State<PopUpActions> createState() => _PopUpActionsState();
}


class _PopUpActionsState extends State<PopUpActions> {
  Actions? selectedMenu;

  @override
  Widget build(BuildContext context) {
    return PopupMenuButton<Actions>(
        initialValue: selectedMenu,
        // Callback that sets the selected popup menu item.
        onSelected: (Actions item) {
          setState(() {
            selectedMenu = item;
          });
        },
        itemBuilder: (BuildContext context) => <PopupMenuEntry<Actions>>[
          const PopupMenuItem<Actions>(
            // value: Actions.mulaiKelas,
            child: Text('Mulai Kelas'),
          ),
          const PopupMenuItem<Actions>(
            // value: Actions.selesaiKelas,
            child: Text('Selesai Kelas'),
          ),
        ],
      );
  }
}




showAlertDialog(BuildContext context,String text, VoidCallback actionFn) {
  // set up the buttons
  Widget cancelButton = TextButton(
    child: const Text("Cancel"),
    onPressed:  () => Navigator.pop(context),
  );
  Widget continueButton = TextButton(
    child: const Text("Continue"),
    onPressed:  actionFn
  );
  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: const Text("Cancel Booking"),
    content:  Text(text),
    actions: [
      cancelButton,
      continueButton,
    ],
  );
  // show the dialog
  showDialog(
    context: context,
    builder: (BuildContext context) {
      return alert;
    },
  );
}



