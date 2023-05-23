import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Function/function.dart';

class ProfileInstrukturPage extends StatelessWidget {
  const ProfileInstrukturPage({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<AppBloc,AppState>(
      builder: (context,state) {
        inspect(state);
        return Scaffold(
          appBar: createAppBar('Profile'),
          body: Column(
            // crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              avatar(),
              Container(
                // decoration: BoxDecoration(border: Border.all(color: Colors.black)),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    semiHeader(state.instruktur!.idInstruktur ?? ''),
                    semiHeader('|'),
                    semiHeader(state.instruktur!.nama ?? ''),
                  ],
                ),
              ),
              partTwo(state),
              partTree(state),
              partFour(state)
            ],
          ),
        );
      }
    );
  }

  Padding partTwo(AppState state) {
    return Padding(
              padding: const EdgeInsets.all(8.0),
              child: Card(child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    subDescription('Address',state.instruktur!.alamat ?? '',Icons.home),
                    subDescription('Born',DateFormatterForView.formatDayMonthYear(state.instruktur!.tglLahir ?? '') ,Icons.date_range_sharp),
                    // subDescription('Phone Number', state.instruktur!.noTelp ?? '' ,Icons.numbers),
                  ],
                ),
              ),),
            );
  }

  Padding partTree(AppState state) {
    return Padding(
              padding: const EdgeInsets.all(8.0),
              child: Card(child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    subDescription('Phone Number',state.instruktur!.noTelp ?? '',Icons.phone_android),
                  ],
                ),
              ),),
            );
  }
  Padding partFour(AppState state) {
    return Padding(
              padding: const EdgeInsets.all(8.0),
              child: Card(child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    subDescription('Accumulated Delayed Class Time',state.instruktur!.telat ?? '',Icons.timelapse_rounded),
                  ],
                ),
              ),),
            );
  }

  Widget subDescription(String textTitle, textDescription, IconData ic) {
    return Center(
      child: Column(
                    children: [
                      Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Row(
                          children: [
                            Icon(ic),
                            Text(textTitle,style: TextStyle(),),
                          ],
                        ),
                      ),
                      Text(textDescription, style :const  TextStyle(fontWeight: FontWeight.bold)),
                    ],
                  ),
    );
  }

  Padding semiHeader(String showText) {
    return Padding(
                    padding: const EdgeInsets.only(left: 10.0, top: 10,bottom: 10,right: 10),
                    child: Center(child: Text(showText,style: TextStyle(fontSize: 25,fontWeight: FontWeight.bold),)),
                  );
  }

  Widget avatar() { 
    return Padding(padding: const EdgeInsets.all(8.0),child: CircleAvatar(child: Icon(Icons.person) , radius: 100,),);
  }
}