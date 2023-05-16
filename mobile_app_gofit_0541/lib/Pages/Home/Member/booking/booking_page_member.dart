import 'package:flutter/material.dart';

//* Component Anakan
import 'booking_kelas.dart';
import 'booking_gym.dart';


class BookingPage extends StatefulWidget {
  const BookingPage({super.key});

  @override
  State<BookingPage> createState() => _BookingPageState();
}

class _BookingPageState extends State<BookingPage> {
  bool setStateBooking = true;
  ScrollController _scrollController = ScrollController();
  @override
  Widget build(BuildContext context) {
    return  ListView(
      controller: _scrollController,
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
          (setStateBooking) ? const BookingGym() :const BookingKelas(),
      ],
    );
  }

  Widget buttonGym() {
    return Padding(
              padding: const EdgeInsets.only(top: 20, bottom: 20),
              child: ElevatedButton(onPressed: (){
                setState(() {
                  setStateBooking = false;
                });
              }, child: Text('Booking Gym'),),
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

