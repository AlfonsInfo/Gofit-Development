import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
// import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:intl/intl.dart';


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
    return SizedBox(
      height: MediaQuery.of(context).size.height * 9/10,
      child: Padding(
        padding: const EdgeInsets.all(40.0),
          child: Form(child: 
          Column(
            children: const [
              //* ID Member
              MemberIDField(),
              //* Date Picker Tanggalnya
              PickerTanggalBooking(),
              //* Drop Down Sesinya
              ComboBoxSesi(),
              //* Button Booking
            ],
          ),),
          // color: ColorApp.colorPrimary,
        ),
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
    return  TextField(
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
                         dateinput.text = formattedDate; //set output date to TextField value. 
                      });
                  }else{
                      print("Date is not selected");
                  }
                },
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
  Sesi? selectedSesi;
  List<Sesi>? daftarSesi = [
    Sesi(idSesi:'1',waktuMulai: '13:00', waktuSelesai:'14:00'),
    Sesi(idSesi:'2',waktuMulai: '15:00', waktuSelesai:'16:00'),
    Sesi(idSesi:'3',waktuMulai: '16:00', waktuSelesai:'16:00'),
  ];

  List<DropdownMenuItem> generateItems(List<Sesi> daftarSesi){
    List<DropdownMenuItem> items = [];
    for(var item in daftarSesi){
        items.add(DropdownMenuItem(child: Text(item.waktuMulai ?? ''),value: item,));
    }
    return items;
  }
  @override
  Widget build(BuildContext context) {
    return DropdownButton(items: generateItems(daftarSesi ?? []),
    value: selectedSesi,
    onChanged: (item) => 
    setState(() {
    selectedSesi = item;
    })
    );
  }
}


class Sesi{
  String? idSesi;
  String? waktuMulai;
  String? waktuSelesai;
  
  Sesi({this.idSesi, this.waktuMulai, this.waktuSelesai});
}
