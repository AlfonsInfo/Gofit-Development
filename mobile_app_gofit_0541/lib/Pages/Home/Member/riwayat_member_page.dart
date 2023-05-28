import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Models/booking_gym.dart';
import 'package:mobile_app_gofit_0541/Models/riwayat_member.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_riwayat_member.dart';

class RiwayatMemberPage extends StatefulWidget {
  const RiwayatMemberPage({super.key});

  @override
  State<RiwayatMemberPage> createState() => _RiwayatMemberPageState();
}

class _RiwayatMemberPageState extends State<RiwayatMemberPage> {
  List<BookingGym> riwayatMember = [];
  RiwayatMemberRepository riwayatMemberRepository = RiwayatMemberRepository();

  @override
  void initState() {
    super.initState();
    getRiwayat();

  }


  getRiwayat() async{
    var appBloc = context.read<AppBloc>();
    var idMember= appBloc.state.member?.idMember;
    riwayatMember = await riwayatMemberRepository.showHistory(idMember ?? '');
    setState(() {});
  }
  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('History Activity'),
      body: ListView.builder(
        itemCount: riwayatMember.length,
        itemBuilder: (context, index) => activityUnit(riwayatMember[index]),
      ),
    );
  }

Widget activityUnit(BookingGym rm) {
  return Builder(
    builder: (BuildContext context) {
      return unitBookingGym(rm);
      // if (rm.namaAktivitas == 'Registrasi Akun') {
      //   return unitRegisterActivity(rm);
      // } else if (rm.namaAktivitas == 'Aktivasi Member') {
      //   return unitActivasiActivity(rm);
      // } else if(rm.namaAktivitas =='Transaksi Deposit Uang'){
      //   return unitDepositUangActivity(rm);
      // }else if(rm.namaAktivitas =='Transaksi Deposit Paket'){
      //   return unitDepoPaketActivity(rm);
      // }else if(rm.namaAktivitas =='Booking Gym Member'){
      //   return unitBookingGym(rm);
      // }else {
      //   return const SizedBox.shrink();
      // }
    },
  );
}

Card unitBookingGym(BookingGym rm){
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
            title: Text('#${rm.noBooking} Sesi ${rm.sesi?.idSesi}' ,style: textStyle,),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                lineDetail('${rm.tanggalSesiGym}', textStyle, Icons.calendar_month),
                lineDetail('${rm.sesi?.waktuMulai} - ${rm.sesi?.waktuSelesai}', textStyle, Icons.av_timer_rounded),
                (rm.statusKehadiran == '1') ? lineDetail('Hadir', textStyle, Icons.co_present): SizedBox.shrink(),
                Text('tanggal booking gym ${rm.tanggalBooking}',  style:  textStyle,),
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
                    // Text('${rm.sesi?.waktuMulai} - ${rm.sesi?.waktuSelesai}',style: textStyle,)
                  ],
                 ),
  );
}
  // Card unitDepoPaketActivity(RiwayatMember rm){
  //     const textStyle = TextStyle(color: Colors.white,backgroundColor: Color.fromARGB(200, 0, 0, 0));
  //     return Card(
  //         margin: const EdgeInsets.all(10),
  //         shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
  //         clipBehavior: Clip.antiAliasWithSaveLayer,
  //         elevation: 5,
  //         child: Container(
  //           decoration: const BoxDecoration(
  //             image: DecorationImage(
  //               image: AssetImage("assets/images/image4.jpg"),
  //               fit: BoxFit.cover,
  //               alignment: Alignment(0, 0),
  //             ),
  //           ),
  //           child:  ListTile(
  //             title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
  //             subtitle: Text('Nice Move', style: textStyle,),
  //           ),
  //         ),
  //       );  
  // }

  // Card unitDepositUangActivity(RiwayatMember rm) {
  //     const textStyle = TextStyle(color: Colors.white,);
  //     return Card(
  //         margin: const EdgeInsets.all(10),
  //         shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
  //         clipBehavior: Clip.antiAliasWithSaveLayer,
  //         elevation: 5,
  //         child: Container(
  //           decoration: const BoxDecoration(
  //             image: DecorationImage(
  //               image: AssetImage("assets/images/image6.jpg"),
  //               fit: BoxFit.cover,
  //               alignment: Alignment.center,
  //             ),
  //           ),
  //           child:  ListTile(
  //             title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
  //             subtitle: Text('Nice Move', style: textStyle,),
  //           ),
  //         ),
  //       );  
  // }

  // Card unitActivasiActivity(RiwayatMember rm){
  //     const textStyle = TextStyle(color: Colors.white,);
  //     return Card(
  //         margin: const EdgeInsets.all(10),
  //         shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
  //         clipBehavior: Clip.antiAliasWithSaveLayer,
  //         elevation: 5,
  //         child: Container(
  //           decoration: const BoxDecoration(
  //             image: DecorationImage(
  //               image: AssetImage("assets/images/image8.jpg"),
  //               fit: BoxFit.cover,
  //               alignment: Alignment.bottomCenter,
  //             ),
  //           ),
  //           child:  ListTile(
  //             title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
  //             subtitle: Text('Nice Move', style: textStyle,),
  //           ),
  //         ),
  //       );  
  // }

  // Card unitRegisterActivity(RiwayatMember rm){
  //     const textStyle = TextStyle(color: Colors.white,);
  //     return Card(
  //         margin: const EdgeInsets.all(10),
  //         shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
  //         clipBehavior: Clip.antiAliasWithSaveLayer,
  //         elevation: 5,
  //         child: Container(
  //           decoration: const BoxDecoration(
  //             image: DecorationImage(
  //               image: AssetImage("assets/images/image9.jpg"),
  //               fit: BoxFit.cover,
  //               alignment: Alignment.center,
  //             ),
  //           ),
  //           child:  ListTile(
  //             title: Text('${rm.namaAktivitas} - ${rm.tanggal}' ,style: textStyle,),
  //             subtitle: Text('Nice Move', style: textStyle,),
  //           ),
  //         ),
  //       );  
  // }
}