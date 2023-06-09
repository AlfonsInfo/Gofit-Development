
import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_jadwal_umum.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/ijin_instruktur/izin_bloc.dart';

//* Drop down List Jadwal ( Jadwal Umum -> Jadwal Harian)
class ListJadwal extends StatefulWidget {
  final Function(JadwalUmum) onSelect;

  const ListJadwal({super.key, required this.onSelect});

  @override
  ListJadwalState createState() => ListJadwalState();
}

class ListJadwalState extends State<ListJadwal> {
  JadwalUmum? _selectedOption;
  late List<JadwalUmum> jadwalUmum = [];
  @override
  void initState() {
    super.initState();
    getJadwalUmum();
  }

  void getJadwalUmum() async {
    var repository = JadwalUmumRepository();
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginJadwalUmum = appBloc.state.instruktur;
    jadwalUmum = await repository.getJadwalByInstruktur(loginJadwalUmum!.idInstruktur);
    inspect(jadwalUmum);
    setState(() {});
  }

  @override
Widget build(BuildContext context) {
  return Padding(
    padding: const EdgeInsets.fromLTRB(30,10,30,10),
    child: Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        const Text('Sesi Izin : '),
        BlocBuilder<IzinBloc,IzinState>(
          builder: (context,state) {
            return Padding(
              padding: const EdgeInsets.all(8.0),
              child: DropdownButton<JadwalUmum>(
                hint: const Text('Pilih Jadwal Yang ingin diganti'),
                value: _selectedOption,
                onChanged: (JadwalUmum? newValue) async {
                  setState(() {
                    _selectedOption = newValue;
                    context.read<IzinBloc>().add(JadwalUmumIzin(idJadwalUmum: _selectedOption!.idJadwalUmum));
                  });
                  setState(() {});
                },
                items: jadwalUmum.map<DropdownMenuItem<JadwalUmum>>((JadwalUmum? value) {
                  return DropdownMenuItem<JadwalUmum>(
                    value: value,
                    child: Text('${value?.hari} ${value?.jamMulai} ${value?.jamSelesai}' ),
                  );
                }).toList(),
              ),
            );
          }
        ),
      ],
    ),
  );
}
}