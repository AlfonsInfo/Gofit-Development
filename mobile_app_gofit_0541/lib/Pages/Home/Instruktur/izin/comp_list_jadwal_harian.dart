
import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_harian.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_jadwal_harian.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/ijin_instruktur/izin_bloc.dart';

//* Drop down List Jadwal ( Jadwal Umum -> Jadwal Harian)
class ListJadwalHarian extends StatefulWidget {
  final Function(JadwalUmum) onSelect;

  const ListJadwalHarian({super.key, required this.onSelect});

  @override
  ListJadwalHarianState createState() => ListJadwalHarianState();
}

class ListJadwalHarianState extends State<ListJadwalHarian> {
  JadwalHarian? _selectedOption;
  late List<JadwalHarian> jadwalHarian = [];
  @override
  void initState() {
    super.initState();
    getJadwalHarian();
  }

  void getJadwalHarian() async {
    var repository = JadwalHarianRepository();
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginJadwalUmum = appBloc.state.instruktur;
  jadwalHarian = await repository.getJadwalByInstruktur(loginJadwalUmum!.idInstruktur);
    // inspect(jadwalUmum);
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
              child: DropdownButton<JadwalHarian>(
                hint: const Text('Pilih Jadwal Umum Pengganti'),
                value: _selectedOption,
                onChanged: (JadwalHarian? newValue) async {
                  setState(() {
                    _selectedOption = newValue;
                    context.read<IzinBloc>().add(JadwalUmumIzin(idJadwalUmum: _selectedOption!.idJadwalHarian));
                  });
                  setState(() {});
                },
                items: jadwalHarian.map<DropdownMenuItem<JadwalHarian>>((JadwalHarian? value) {
                  return DropdownMenuItem<JadwalHarian>(
                    value: value,
                    child: Text('Alfons Ganteng' ),
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