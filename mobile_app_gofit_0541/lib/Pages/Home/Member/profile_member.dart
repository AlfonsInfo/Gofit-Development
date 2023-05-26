import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Function/function.dart';

class ProfileMemberPage extends StatelessWidget {
  const ProfileMemberPage({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<AppBloc,AppState>(
      builder: (context,state) {
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
                    semiHeader(state.member!.idMember ?? ''),
                    semiHeader('|'),
                    semiHeader(state.member!.namaMember ?? ''),
                  ],
                ),
              ),
              partTwo(state),
              partTree(state),
              partFour(state),
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
                    subDescription('Address',state.member!.alamatMember ?? '',Icons.home),
                    subDescription('Born',DateFormatterForView.formatDayMonthYear( state.member!.tglLahirMember ?? '') ,Icons.date_range_sharp),
                    subDescription('Phone Number',state.member!.noTelpMember ?? '' ,Icons.phone_android),
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
                    subDescription('Active Period',DateFormatterForView.formatDayMonthYear(state.member!.tglKadeluarsaAktivasi ?? '') ,Icons.star_border_outlined),
                    // subDescription('Deposit Money',state.member!.totalDepositUang ?? '' ,Icons.money),
                    // subDescription('Deposit Class',state.member!.totalDepositUang ?? '' ,Icons.money),
                    // subDescription('No Telp',state.member!.noTelpMember ?? '' ,Icons.numbers),
                  ],
                ),
              ),),
    );
  }

  Padding partFour(AppState state) {
    String totalDepositUang = CurrencyFormatter.rupiahFormatter(state.member!.totalDepositUang ?? '');
    // String maasaBerlaku = state.member.
    return Padding(
              padding: const EdgeInsets.all(8.0),
              child: Card(child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    // subDescription('Active Period',DateFormatterForView.formatDayMonthYear(state.member!.tglKadeluarsaAktivasi ?? '') ,Icons.star_border_outlined),
                    subDescription('Deposit Money','${totalDepositUang}'  ,Icons.money),
                    subDescription('Deposit Class','${state.member!.totalDepositPaket} - ${state.member!.kelas?.jenisKelas}'  ,Icons.sports_gymnastics),
                    // subDescription('No Telp',state.member!.noTelpMember ?? '' ,Icons.numbers),
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