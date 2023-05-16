// import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/ijin_instruktur/izin_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:intl/intl.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'comp_list_instruktur.dart';
import 'comp_list_jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';


//* Main Ijin Pagesub
class IjinPages extends StatefulWidget {
  const IjinPages({Key? key}) : super(key: key);

  @override
  State<IjinPages> createState() => _IjinPagesState();
}

class _IjinPagesState extends State<IjinPages> {

  @override
  Widget build(BuildContext context) {
    //* Current Date
    DateTime now = DateTime.now();
    DateTime date = DateTime(now.year, now.month, now.day);
    var formatter = DateFormat('dd-MM-yyyy');
    String stringDate = formatter.format(date);

    return  BlocProvider(
      create: (context) => IzinBloc(),
      child: Scaffold(
        appBar: createAppBar('Form Perijinan Instruktur'),
        body: Column(
          children: [
            const HeaderTemplate(message: 'Perijinan Instruktur :'),
            Form(child: Column(
              children: [
                fieldNama(),
                fieldTanggal(stringDate),
                ListInstruktur(onSelect: (Instruktur selected) => setState(() {}),),             
                ListJadwal(onSelect: ( JadwalUmum selected) => setState(() {}),),             
                btnIjin()
              ],
            ),)
          ],
        ),
      ),
    );
  }
  //* Akhir dari ijin main pages


  //* Tanggal
  Widget fieldTanggal(String stringDate) {
    return BlocBuilder<IzinBloc,IzinState>(
      builder: (context,state) {
        return Padding(
          padding: const EdgeInsets.fromLTRB(30,10,30,10),
            child: TextFormField(
              enabled: false,
              initialValue: stringDate,
              decoration: const InputDecoration(
              hintText: 'Tanggal Pengajuan',
              label: Text('Tanggal Pengajuan')
                ),
            ),
        );
      }
    );
  }

  //* Nama
  Widget fieldNama() {
    return Padding(
      padding: const EdgeInsets.fromLTRB(30,10,30,10),
      child: BlocBuilder<AppBloc,AppState>(
        builder: (context,state){
        return TextFormField(
          enabled: false,
          initialValue: '${state.instruktur?.nama}',
          decoration: const InputDecoration(
            hintText: 'Nama Instruktur',
            label: Text('Nama Instruktur')
          ),
        );
        }
      ),
    );
  }
}

  //* Btn Ijin
  Widget btnIjin() {
  //  return BlocBuilder<ResetBloc,ResetState>(
      // builder: ((context, state) {
      return BlocBuilder<IzinBloc,IzinState>(
        builder: (context,state) {
          return Padding(
            padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: ElevatedButton(
              onPressed: (){
                var appBloc = context.read<AppBloc>();
                var idInstruktur = appBloc.state.instruktur?.idInstruktur;
                var izinBloc = context.read<IzinBloc>();
                var idJadwal = izinBloc.state.idJadwalUmum;
                context.read<IzinBloc>().add(IzinSubmitted(idInstruktur: idInstruktur, idInstrukturPengganti: izinBloc.state.idInstrukturPengganti, idJadwalUmum:  idJadwal));
                _showSnackBar(context, 'Berhasil Izin');
                Navigator.of(context).pop();
              },
              child: const Text('Ajukan Ijin')),
            );
        }
      );
      // }),
    // );
  }

  //* Snackbar
  void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }
  
