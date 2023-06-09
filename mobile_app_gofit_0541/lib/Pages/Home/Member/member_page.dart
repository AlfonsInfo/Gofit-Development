import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'home_page_member.dart';
import 'booking/booking_member_page.dart';

class MemberPage extends StatefulWidget {
  const MemberPage({super.key});

  @override
  State<MemberPage> createState() =>
      _MemberPageState();
}

class _MemberPageState extends State<MemberPage> {
  int _selectedIndex = 0;

  // static const TextStyle optionStyle =
      // TextStyle(fontSize: 30, fontWeight: FontWeight.bold);
  static const List<Widget> _widgetOptions = <Widget>[
    HomePageMember(),
    BookingPage(),
    // Text(
    //   'Index 2: School',
    //   // style: optionStyle,
    // ),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: createAppBar(''),
      body: Container(
        child: _widgetOptions.elementAt(_selectedIndex),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
        BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.business),
            label: 'Booking',
          ),
          // BottomNavigationBarItem(
          //   icon: Icon(Icons.school),
          //   label: 'History',
          // ),
        ],
        currentIndex: _selectedIndex,
        selectedItemColor: ColorApp.colorButtonPrimary,
        onTap: _onItemTapped,
      ),
    drawer: const SideBar(alamatRoute: '/profilemember', alamatListRiwayat: '/riwayataktivitasmember'),
    );
  }
}
