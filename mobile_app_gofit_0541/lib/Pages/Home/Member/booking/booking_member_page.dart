import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/booking_gym/booking_gym_bloc.dart';
//* Component Anakan
import 'booking_kelas_page.dart';
import 'booking_gym_page.dart';


class BookingPage extends StatefulWidget {
  const BookingPage({super.key});

  @override
  State<BookingPage> createState() => _BookingPageState();
}

class _BookingPageState extends State<BookingPage> {
  bool setStateBooking = true;
  @override
  Widget build(BuildContext context) {
    return  BlocProvider(
      create: (context) => BookingGymBloc(),
      child: Column(
        children: [
          //* Button Booking kelas  / Gym
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                buttonKelas(),
                buttonGym(),  
              ],
            ),
            //* Akhir dari Button
            (setStateBooking) ?  const BookingKelasPage() : const BookingGym(),
        ],
      ),
    );
  }

  Widget buttonGym() {
    return Padding(
      padding: const EdgeInsets.only(top: 20, bottom: 20),
        child: ElevatedButton(onPressed: (){
          setState(() {
            setStateBooking = false;
        });
      }, child: const Text('Booking Gym'),),
    );
  }

  Widget buttonKelas() {
    return Padding(
      padding: const EdgeInsets.only(top: 20, bottom: 20),
        child: ElevatedButton(onPressed: (){
          setState(() {
            setStateBooking = true;
          });
        }, child: Text('Booking Kelas'),),
      );
    } 
  }

