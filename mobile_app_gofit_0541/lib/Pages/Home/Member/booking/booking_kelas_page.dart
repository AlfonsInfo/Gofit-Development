import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Models/kelas.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_booking_gym.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_booking_kelas.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class BookingKelasPage extends StatefulWidget {
  const BookingKelasPage({
    super.key,
  });

  @override
  State<BookingKelasPage> createState() => _BookingKelasPageState();
}

class _BookingKelasPageState extends State<BookingKelasPage> {

  BookingKelasRepository bookingKelasRepository = BookingKelasRepository();
  List<JadwalHarian> kelas = [];

  @override
  initState(){
    super.initState();
    getKelas();
  }

  getKelas() async{
    // var idInstruktur =  appBloc.state.instruktur?.idInstruktur ;
    kelas = await bookingKelasRepository.showClass();
    setState(() {});
  }
  @override
  Widget build(BuildContext context) {
    return Expanded(
      // height: MediaQuery.of(context).size.height * 9/10,
      child : ListView.builder(
        itemCount: kelas.length,
        itemBuilder: (context, index) => unitKelas(context,kelas[index]),
      ),
      );
  }
}


Card unitKelas(BuildContext context, JadwalHarian rm){
    const textStyle = TextStyle(color: Colors.white, backgroundColor: Colors.black);
    
    void bookingKelas() async{
    var appBloc = context.read<AppBloc>();
    var idMember = appBloc.state.member?.idMember;
    BookingKelasRepository bookingKelasRepository = BookingKelasRepository();
    var response = await bookingKelasRepository.store(idMember: idMember ?? '', idJadwalHarian: rm.idJadwalHarian ?? '');
    showSnackBarMessage(context, response[0]);

      Navigator.pop(context);
    }
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
            title: Text('#${rm.jadwalUmum?.kelas?.jenisKelas} - ${rm.tanggal} (${rm.jadwalUmum?.jamMulai} ${rm.jadwalUmum?.jamSelesai})' ,style: textStyle,),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                lineDetail('Price : Rp. ${rm.jadwalUmum?.kelas?.hargaKelas}', textStyle, Icons.money),
                lineDetail('Instructure : ${rm.jadwalUmum?.instruktur?.nama}', textStyle, Icons.person),
                lineDetail('Class Participant: ${rm.jumlahPeserta} of 10', textStyle, Icons.star_rounded)
              ],
            ),
            trailing: ElevatedButton(onPressed: (){
              showAlertDialog(context,bookingKelas);
            }, child: Text('Booking')),
          onTap: () {
            
          },
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

showAlertDialog(BuildContext context, VoidCallback continueAction) {
  // set up the buttons
  Widget cancelButton = TextButton(
    child: const Text("Cancel"),
    onPressed:  () => Navigator.pop(context),
  );
  Widget continueButton = TextButton(
    child: const Text("Continue"),
    onPressed:  continueAction
  );
  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: const Text("Booking Class"),
    content: const Text("Are you sure to booked this class ?"),
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

void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
}
  

//*Booking Kelas -> Store / Create data booking kelas
//* Tampilkan Kelasnya Apa

//* Periksa Status Aktif / Tidak

//* Periksa Kuota Masih Ada atau Tidak

//* Generate No Booking
