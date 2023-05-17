import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
  import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:intl/intl.dart';
import 'package:mobile_app_gofit_0541/Bloc/booking_gym/booking_gym_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/booking_gym/form_booking_gym.dart';
import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_sesi.dart';


class BookingGym extends StatefulWidget {
  const BookingGym({
    super.key,
  }); 
  
  @override
  State<BookingGym> createState() => _BookingGymState();
}

class _BookingGymState extends State<BookingGym> {

  @override
  Widget build(BuildContext context) {
    return  BlocListener<BookingGymBloc, BookingGymState>(
      listener: (context, state) {
        final formStatus = state.formStatus;
        // inspect(formStatus);
        if( formStatus is SubmissionSuccess){
          _showSnackBar(context, state.message);
          Navigator.pushNamed(context, '/homeMember');
        }else if(formStatus is SubmissionFailed){
          _showSnackBar(context, state.message);
        }else{}
      },
        child : SizedBox(
          height: MediaQuery.of(context).size.height * 9/10,
          child: Padding(
            padding: const EdgeInsets.all(40.0),
              child: Form(child: 
              Column(
                children:  [
                  //* ID Member
                  const MemberIDField(),
                  //* Date Picker Tanggalnya
                  const PickerTanggalBooking(),
                  //* Drop Down Sesinya
                  const ComboBoxSesi(),
                  //* Button Booking
                  buttonBooking()
                ],
              ),),
              // color: ColorApp.colorPrimary,
            ),
          )
    );
  }

  Widget buttonBooking() {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: ElevatedButton(
        onPressed: (){
      //* Aksi
      var appBloc = context.read<AppBloc>();
      var idMember = appBloc.state.member?.idMember;
      context.read<BookingGymBloc>().add(BookingSubmitted(idMember: idMember));
      }, child: const Text('Booking Bro !!')),
    );
  }
}

//!--- KOMPONEN PENYUSUN  ---!//

//* Field Member
class MemberIDField extends StatelessWidget {
  const MemberIDField({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<AppBloc,AppState>(
      builder: (context,appState) {
        return TextFormField(
          enabled: false,
          initialValue: appState.member!.idMember,
          decoration: const InputDecoration(
            labelText: 'ID MEMBER',
            icon: Icon(Icons.card_membership)
          ),
          );
      }
    );
  }
}



//* Date Picker
class PickerTanggalBooking extends StatefulWidget {
  const PickerTanggalBooking({super.key});
  @override
  State<PickerTanggalBooking> createState() => PickerTanggalBookingState();
}

class PickerTanggalBookingState extends State<PickerTanggalBooking> {
  //* Initial Value
  TextEditingController dateinput = TextEditingController(); 


  @override
  void initState() {
    dateinput.text = ""; //set the initial value of text field
    super.initState();
  } 

  @override
  Widget build(BuildContext context) {
    return  BlocBuilder<BookingGymBloc, BookingGymState>(
      builder: (context, bookingGymState) {
        return TextField(
                    controller: dateinput, //editing controller of this TextField
                    decoration: const InputDecoration( 
                       icon: Icon(Icons.calendar_today), //icon of text field
                       labelText: "Booking untuk tanggal berapa ?" //label text of field
                    ),
                    readOnly: true,  //set it true, so that user will not able to edit text
                    onTap: () async {
                      DateTime? pickedDate = await showDatePicker(
                          context: context, initialDate: DateTime.now(),
                          firstDate: DateTime.now()  , //DateTime.now() - not to allow to choose before today.
                          lastDate: DateTime(2101),
                      );
                      
                      if(pickedDate != null ){
                          String formattedDate = DateFormat('yyyy-MM-dd').format(pickedDate); 
                          setState(() {
                            //* Format tampil 
                             dateinput.text = formattedDate; //set output date to TextField value. 
                            //* Simpan ke state
                            context.read<BookingGymBloc>().add(DateChanged(date: formattedDate));
                          });
                      }else{
                          print("Date is not selected");
                      }
                    },
                );
      }
    );
  }
}


//* Combo box sesi gym
class ComboBoxSesi extends StatefulWidget {
  const ComboBoxSesi({super.key});

  @override
  State<ComboBoxSesi> createState() => _ComboBoxSesiState();
}

class _ComboBoxSesiState extends State<ComboBoxSesi> {
  
  //* Konversi List Sesi menjadi List DropDownMenuItem
  List<DropdownMenuItem> generateItems(List<Sesi> daftarSesi){
    List<DropdownMenuItem> items = [];
    for(var item in daftarSesi){
        items.add(DropdownMenuItem(
          value: item,
          child: Text('${item.waktuMulai} - ${item.waktuSelesai}'),
          ),);
    }
    return items;
  }
  Sesi? selectedSesi;
  // final BookingGymBloc bookingGymBLoc = BlocProvider.of<BookingGymBloc>(context);
  late List<Sesi> daftarSesi = [];

  @override
  initState(){
    super.initState();
    getSesi(context);
  }

  getSesi(BuildContext context) async {
    SesiRepository sesiRepository = SesiRepository();
    daftarSesi = await sesiRepository.getSesi();
    setState(() {});
    // daftarSesi = bookingGymBLoc.state.defaultSesi ?? [];
  }

  filterDate(){}


  @override
  Widget build(BuildContext context) {
      
    return BlocListener<BookingGymBloc,BookingGymState>(
      listener: (context,state) { 
        //* Ngecek Kalau Hari ini Batasin Jamnya 
      },
      child: BlocBuilder<BookingGymBloc,BookingGymState>(
          builder: (context,bookingState) {
            return Padding(
              padding: const EdgeInsets.all(4.0),
              child: Column(
                children: [
                  Row(
                    children: [
                      const Padding(
                        padding:  EdgeInsets.only(right: 12),
                        child: Icon(Icons.watch_later_outlined),
                      ),
                      Expanded(
                        child: DropdownButton(items: generateItems(daftarSesi),
                        value: selectedSesi,
                        onChanged: (item) {
                        setState(() {
                        selectedSesi = item;
                        context.read<BookingGymBloc>().add(SesiChanged(sesi: selectedSesi?.idSesi));
                        });
                        },
                        hint: const Text('Jam Berapa ?'),
                        isExpanded: true,
                        ),
                      ),
                    ],
                  ),
                  // ElevatedButton(onPressed: (){
                  //   inspect(daftarSesi);
                  // }, child: Text('pencet'))
                ],
              ),
              //   Future<Object?> testMethod(BookingGymBloc bookingGymBLoc) async => inspect(await bookingGymBLoc.state.defaultSesi);

            );
          }
        ),);
      }
  }



  //* Methods
  void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }
  
// class Sesi{
//   String? idSesi;
//   String? waktuMulai;
//   String? waktuSelesai;
  
//   Sesi({this.idSesi, this.waktuMulai, this.waktuSelesai});
// }


//  bookingState.defaultSesi?.map<DropdownMenuItem<Sesi>>((Sesi? value) {
//                   return DropdownMenuItem<Sesi>(
//                     value: value,
//                     child: Text(value?.waktuMulai ?? 'Pilih Instruktur'),
//                   );