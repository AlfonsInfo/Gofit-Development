import 'dart:developer';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Models/booking_gym.dart';
import 'package:mobile_app_gofit_0541/Models/booking_kelas.dart';
import 'package:mobile_app_gofit_0541/Models/riwayat_member.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_riwayat_member.dart';

const List<Widget> menuRiwayat = <Widget>[
  Padding(
    padding: EdgeInsets.all(8.0),
    child: Text('Booking Gym'),
  ),
  Padding(
    padding: EdgeInsets.all(8.0),
    child: Text('Booking Kelas'),
  ),
];

class RiwayatMemberPage extends StatefulWidget {
  const RiwayatMemberPage({super.key});

  @override
  State<RiwayatMemberPage> createState() => _RiwayatMemberPageState();
}

class _RiwayatMemberPageState extends State<RiwayatMemberPage> {
  List<BookingGym> riwayatMemberGym = [];
  List<BookingKelas> riwayatMemberKelas = [];
  List<dynamic> temp = [];
  RiwayatMemberRepository riwayatMemberRepository = RiwayatMemberRepository();
  TextEditingController waktuMulai = TextEditingController(); 
  TextEditingController waktuSelesai = TextEditingController(); 

  bool toggleFilterSearch = true; 


  final List<bool> _selectedMenu = <bool>[true,false];

  @override
  void initState() {
    super.initState();
    waktuMulai.text = ""; //set the initial value of text field
    waktuSelesai.text = ""; //set the initial value of text field

    getRiwayat();

  }


  getRiwayat() async{
    var appBloc = context.read<AppBloc>();
    var idMember= appBloc.state.member?.idMember;
    riwayatMemberGym = await riwayatMemberRepository.showHistoryGym(idMember ?? '');
    riwayatMemberKelas = await riwayatMemberRepository.showHistoryKelas(idMember ?? '');
    setState(() {});
  }


  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('History Activity'),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
         Padding(
           padding: const EdgeInsets.only(top: 15),
           child: toggleRiwayat(),
         ),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              dateInput(context, 'Start Date', waktuMulai),
              dateInput(context, 'End Date', waktuSelesai),
              (toggleFilterSearch) ?
                //* Tombol Search
                TextButton(
                  onPressed: () async {
                    //* Jika masih kosong hentikan proses
                    if(waktuMulai.text.isEmpty || waktuSelesai.text.isEmpty){
                      showSnackBarMessage(context, 'Please fill start date and end date');
                      return;
                    }
                    //* jika sudah diisi, coba cek dia berada di riwayat booking gym atau riwayat booking kelas, lakukan aksi sesuai kondisi 
                    if(_selectedMenu[0] == true){
                      //* Booking Gym
                        temp = riwayatMemberGym;
                        var appBloc = context.read<AppBloc>();
                        var idMember= appBloc.state.member?.idMember;
                      riwayatMemberGym = await riwayatMemberRepository.showHistoryGymFilter(idMember ?? '',waktuMulai.text, waktuSelesai.text);
                    }else{
                      //* Booking kelas
                      temp = riwayatMemberKelas;
                      var appBloc = context.read<AppBloc>();
                      var idMember= appBloc.state.member?.idMember;
                      riwayatMemberKelas = await riwayatMemberRepository.showHistoryKelasFilter(idMember ?? '',waktuMulai.text, waktuSelesai.text);
                      }
                    inspect(temp);
                    // if()
                    toggleFilterSearch = false;
                    setState(() {});
                  }, 
                  child: Text('Search')):
                //* Tombol Batal Search & Kembali Menampilkan Seluruh Data
                TextButton(onPressed: (){
                  toggleFilterSearch = true;
                  if(_selectedMenu[0] == true){
                    riwayatMemberGym = temp as List<BookingGym>;
                  }else{
                    riwayatMemberKelas = temp as List<BookingKelas>;
                  }
                  setState(() {});
                }, child: Text('Cancel'))
            ],
          ),
          (_selectedMenu[0] == true) ? Expanded(
            child: ListView.builder(
              itemCount: riwayatMemberGym.length,
              itemBuilder: (context, index) => unitBookingGym(riwayatMemberGym[index]),
            ),
          ) : Expanded(
            child: ListView.builder(
              itemCount: riwayatMemberKelas.length,
              itemBuilder: (context, index) => unitBookingKelas(riwayatMemberKelas[index]),
            ),
          ) 
          
        ],
      ),
    );
  }

  ToggleButtons toggleRiwayat() {
    return ToggleButtons(
                // direction: vertical ? Axis.vertical : Axis.horizontal,
                onPressed: toggleFilterSearch ? (int index) {
                  setState(() {
                    // The button that is tapped is set to true, and the others to false.
                    for (int i = 0; i < _selectedMenu.length; i++) {
                      _selectedMenu[i] = i == index;
                      waktuMulai.text = '';
                      waktuSelesai.text = '';
                    }
                  });
                } : null,
                borderRadius: const BorderRadius.all(Radius.circular(8)),
                selectedBorderColor: ColorApp.colorPrimary,
                selectedColor: Colors.white,
                fillColor: ColorApp.colorPrimary,
                color: Colors.red[400],
                constraints: const BoxConstraints(
                  minHeight: 40.0,
                  minWidth: 80.0,
                ),
                isSelected: _selectedMenu,
                children: menuRiwayat,
              );
  }
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
                Text('Tanggal Booking Gym ${rm.tanggalBooking}',  style:  textStyle,),
                (rm.waktuPresensi != '') ? Text('Waktu Presensi ${rm.waktuPresensi}',  style:  textStyle,) : Text('Belum melakukan presensi', style:  textStyle),
              ],
            ),
          ),
        ),
      );  
}
Card unitBookingKelas(BookingKelas rm){
    const textStyle = TextStyle(color: Colors.white, backgroundColor: Color.fromARGB(200, 0, 0, 0));
    return Card(
        margin: const EdgeInsets.all(10),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        elevation: 5,
        child: Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
              image: AssetImage("assets/images/image2.jpg"),
              fit: BoxFit.cover,
              alignment: Alignment.topCenter,
            ),
          ),
          child:  ListTile(
            title: Text('#${rm.noBooking} ' ,style: textStyle,),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                lineDetail('${rm.jadwalHarian?.jadwalUmum?.hari} ${rm.jadwalHarian?.tanggal}', textStyle, Icons.calendar_month),
                lineDetail('${rm.jadwalHarian?.jadwalUmum?.jamMulai} -${rm.jadwalHarian?.jadwalUmum?.jamSelesai}', textStyle, Icons.av_timer_rounded),
                lineDetail('${rm.jadwalHarian?.jadwalUmum?.instruktur?.nama}', textStyle, Icons.person),
                lineDetail('Rp ${rm.jadwalHarian?.jadwalUmum?.kelas?.hargaKelas}', textStyle, Icons.money),
                Text('Booking Pada ${rm.tanggalBooking}', style: textStyle,),
                (rm.metodePembayaran != '') ? 
                Text('Metode Pembayaran Menggunakan :   ${rm.metodePembayaran}', style: textStyle,) : SizedBox.shrink()
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

SizedBox dateInput(BuildContext context,label, TextEditingController textcontroller) {
    return SizedBox(
    width: MediaQuery.of(context).size.width * 0.3,
    child: Center( 
       child:TextField(
          controller: textcontroller, //editing controller of this TextField
          decoration: InputDecoration( 
             icon: Icon(Icons.calendar_today), //icon of text field
             labelText: label //label text of field
          ),
          readOnly: true,  //set it true, so that user will not able to edit text
          onTap: () async {
            DateTime? pickedDate = await showDatePicker(
                context: context, initialDate: DateTime.now(),
                firstDate: DateTime(2000), //DateTime.now() - not to allow to choose before today.
                lastDate: DateTime(2101)
            );
            
            if(pickedDate != null ){
                String formattedDate = DateFormat('yyyy-MM-dd').format(pickedDate); 
                textcontroller.text = formattedDate;
            }else{
                print("Date is not selected");
            }
          },
       )
    ),
  );
  }



// class DateFilter extends StatefulWidget{
//   @override
//   State<StatefulWidget> createState() {
//     return _DateFilter();
//   }
// }

// class _DateFilter extends State<DateFilter>{
//   TextEditingController dateinput = TextEditingController(); 
//   //text editing controller for text field
  
//   @override
//   void initState() {
//     dateinput.text = ""; //set the initial value of text field
//     super.initState();
//   }

//   @override
//   Widget build(BuildContext context) {
//     return Row(
//       mainAxisAlignment: MainAxisAlignment.center,
//       children: [
//         dateInput(context,'waktu mulai'),
//         dateInput(context, 'waktu selesai'),
//       ],
//     );
//   }

  
// }

  //* Methods
  void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }