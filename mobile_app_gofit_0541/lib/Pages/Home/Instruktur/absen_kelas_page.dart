import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/booking_kelas.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_booking_kelas.dart';

class AbsenKelasPage extends StatefulWidget {
  const AbsenKelasPage({super.key});

  @override
  State<AbsenKelasPage> createState() => _AbsenKelasPageState();
}

class _AbsenKelasPageState extends State<AbsenKelasPage> {
  List bookingKelas = [];
  BookingKelasRepository bookingKelasRepository = BookingKelasRepository();
  @override
  initState(){
    super.initState();
    getBookingKelas();
  }

    getBookingKelas () async{
    var appBloc = context.read<AppBloc>();  
    var idJadwal = appBloc.state.jadwalHarian?.idJadwalHarian;
    bookingKelas =  await bookingKelasRepository.show(idJadwal ?? '');
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: createAppBar('Absen kelas'),
      body: BlocBuilder<AppBloc, AppState>(
        builder: (context, state) {
          return Column(
            children : [
              HeaderTemplate(message: 'Absen Kelas ${state.jadwalHarian!.jadwalUmum!.kelas!.jenisKelas}'),
              Expanded(
                child: ListView.builder(
                  itemCount: bookingKelas.length,
                  itemBuilder: (context, index) =>cardMember(bookingKelas[index]),  
                ),
              )
            // testingButtonCielah(state)
            ]
          );
        },
      ),
    );
  }

  Widget cardMember(BookingKelas bk){
    confirmAttedance() async{
        BookingKelasRepository bookingKelasRepository = BookingKelasRepository();
        var Result = await bookingKelasRepository.presensiKelas(bk.noBooking ?? '' );
        showSnackBarMessage(context, Result[0]);
        Navigator.pop(context);
        getBookingKelas();
    }
    confirmAbsenceClass() async{
        BookingKelasRepository bookingKelasRepository = BookingKelasRepository();
        var Result = await bookingKelasRepository.absenKelas(bk.noBooking ?? '' );
        showSnackBarMessage(context, Result[0]);
        Navigator.pop(context);
        getBookingKelas();
    }
    return Card(child: Padding(
      padding: const EdgeInsets.all(8.0),
      child: Row(
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text('No Booking : ${bk.noBooking}' ),
              Text('ID Member : ${bk.member!.idMember} Nama Member : ${bk.member!.namaMember}' ),
              
              if (bk.statusKehadiran == '0')  messageAbsence()
              else if(bk.statusKehadiran == '1')messageAttedanceConfirm() 
              else buttonConfirmAttedance(bk, confirmAttedance, confirmAbsenceClass)
            ],
          ),
        ],
      ),
    ));
  }

  Container messageAttedanceConfirm() {
    return Container(
              color: Colors.green,
              child: const Padding(padding: EdgeInsets.all(8),child: Text('presence has been confirmed',style: TextStyle(color: Colors.white),),));
  }
  Container messageAbsence() {
    return Container(
              color: Colors.red,
              child: const Padding(padding: EdgeInsets.all(8),child: Text('member were not present',style: TextStyle(color: Colors.white),),));
  }

  Padding buttonConfirmAttedance(BookingKelas bk, Future<Null> confirmAttedance(), Future<Null> confirmAbsenceClass()) {
    return Padding(
              padding: const EdgeInsets.all(8.0),
              child: ElevatedButton(onPressed: (){
                showAlertDialog(context, 'Are you sure to confirm ${bk.member!.namaMember} attedance ?', confirmAttedance, confirmAbsenceClass);
              }, child: const Text('Confirm Attedance')),
            );
  }

  ElevatedButton testingButtonCielah(AppState state) {
    return ElevatedButton(child: const Text('test'), onPressed: () {
            inspect(state.jadwalHarian);
          },);
  }
}



showAlertDialog(BuildContext context,String text, VoidCallback actionFn, VoidCallback actionFn2){
  // set up the buttons
  Widget cancelButton = TextButton(
    child: const Text("Cancel"),
    onPressed:  () => Navigator.pop(context),
  );
  Widget confirmPresence = TextButton(
    child: const Text("Mark Attendance`"),
    onPressed:  actionFn
  );
  Widget confirmAbsence = TextButton(
    child: const Text("Mark Absence"),
    onPressed:  actionFn2
  );
  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: const Text("Cancel Booking"),
    content:  Text(text),
    actions: [
      cancelButton,
      confirmPresence,
      confirmAbsence,
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