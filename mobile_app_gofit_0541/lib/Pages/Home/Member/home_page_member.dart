import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';
import 'package:scroll_loop_auto_scroll/scroll_loop_auto_scroll.dart';

//* HomePageMember
class HomePageMember extends StatelessWidget {
  const HomePageMember({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          headerHomeMember(),
          Center(child: HeaderTemplate(message: '-Upcoming Reservation-')),
          Expanded(
            child: ListView(
              children: [
                classCard('Yoo'),
                classCard('Mantap Banget'),
                classCard('Ga si'),
                classCard('Yoo'),
                classCard('Mantep'),
              ],
            ),
          )
          // HeaderTemplate(message: '-Upcoming Reservation-'),
          // HeaderTemplate(message: '-Upcoming Reservation-'),
          
        ],
      ),
    );
  }

    Widget classCard(String title) {
    return Padding(
      padding: const EdgeInsets.all(4.0),
      child: Card(
          child: ListTile(
            leading: const FlutterLogo(size: 72.0),
            title: Text(title),
            subtitle:
                const Text('A sufficiently long subtitle warrants three lines.'),
                trailing:  const Icon(Icons.more_vert),
            isThreeLine: true,
          ),
        ),
    );
    }

}

class headerHomeMember extends StatelessWidget {
  const headerHomeMember({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      // decoration: BoxDecoration(border: Border.all(color: Colors.black)),
      height: MediaQuery.of(context).size.height * 1 / 3.2,
      child: Stack(
        children: [
          SizedBox(
            child: Container(
              width: MediaQuery.of(context).size.width * 1,
              height: MediaQuery.of(context).size.height * 1 / 4,
              decoration: const BoxDecoration(
                color: ColorApp.colorPrimary,
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(10),
                  bottomRight: Radius.circular(10),
                ),
              ),
            ),
          ),
          Align(
            alignment: Alignment.bottomCenter,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                // AnimatedListView(),
                // boxContent(), 
                boxContent2(),
              ],
            ),
          ),
          BlocBuilder<AppBloc,AppState>(
            builder: (context,state) {
              return Align(
                alignment: Alignment.topLeft,
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text('Welcome Back, ${state.member?.namaMember}' , style: TextStyle(color: Colors.white,fontSize: 25), ),
                ),
              );
            }
          )
        ],
      ),
    );
  }
}




Container boxContent() {
  return Container(
    // width: 100,
    height: 100,
    decoration: BoxDecoration(
      color: Colors.white,
      borderRadius: BorderRadius.all(Radius.circular(10)),
      border: Border.all(color: ColorApp.colorButtonPrimary)
    ),
    child: BlocBuilder<AppBloc,AppState>(
      builder: (context,state) {
        return GestureDetector(
          onTap: 
          () => DetailSaldo(context),
          child: ScrollLoopAutoScroll(
            // delay: Duration(seconds: 5 ),
            // duration: Duration(seconds: 10),
            // gap: 25,
            scrollDirection: Axis.vertical,
            child: Column(
              children: [
                Container(
                  width: 100,
                  height: 100,
                  child: Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Center(child: Text('Deposit Uang : Rp  ${state.member?.totalDepositUang}')),
                  ),),
                Container(
                  width: 100,
                  height: 100,
                  child: Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Center(child: Text('Deposit paket : ${state.member?.totalDepositPaket}')),
                  ),),
                // Daftar item di dalam ListView
              ],
            ),
          ),
        );
      }
    ),
  );
}

Future<void> DetailSaldo(BuildContext context) {
  return showModalBottomSheet<void>(
          context: context,
          builder: (BuildContext context) {
            return Container(
              height: 200,
              color: Colors.amber,
              child: Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  mainAxisSize: MainAxisSize.min,
                  children: <Widget>[
                    const Text('Modal BottomSheet'),
                    ElevatedButton(
                      child: const Text('Close BottomSheet'),
                      onPressed: () => Navigator.pop(context),
                    ),
                  ],
                ),
              ),
            );
          },
        );
}
Container boxContent2() {
  return Container(
    width: 100,
    height: 100,
    decoration: BoxDecoration(
      color: Colors.white,
      borderRadius: BorderRadius.all(Radius.circular(10)),
      border: Border.all(color: ColorApp.colorButtonPrimary)
    ),
    child: Container(
      width: 100,
      height: 100,
      child: IconButton(onPressed: (){}, icon: Icon(Icons.add))
  ),);
}







