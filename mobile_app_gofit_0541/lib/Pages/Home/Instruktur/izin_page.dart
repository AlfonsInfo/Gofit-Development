// import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/ijin_instruktur/izin_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:intl/intl.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_instruktur.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
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


    // * Ngambil Data Seluruh Instruktur
    // InstrukturRepository instrukturRepo = InstrukturRepository();
    // instrukturRepo.getInstruktur();
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
                ListInstruktur(
                    onSelect: (Instruktur selected) => setState(() {}),
                  ),             
                ListJadwal(
                  onSelect: ( JadwalUmum selected) => setState(() {}),
                  ),             
                btnIjin()
              ],
            ))
          ],
        ),
      ),
    );
  }

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

class ListInstruktur extends StatefulWidget {
  final Function(Instruktur) onSelect;

  const ListInstruktur({super.key,  required this.onSelect});

  @override
  _ListInstrukturState createState() => _ListInstrukturState();
}
class _ListInstrukturState extends State<ListInstruktur> {
  Instruktur? _selectedOption;
  JadwalUmum? _selectdJadwal;
  late List<Instruktur> instrukturs = [];
  late List<JadwalUmum> availableJadwal = [];
  @override
  void initState() {
    super.initState();
    getInstruktur();
    // getAvailableJadwal();
  }

  void filterLoginInstruktur()  {
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginInstruktur = appBloc.state.instruktur;
    setState(() {
      instrukturs = instrukturs.where((instruktur) => instruktur.nama != loginInstruktur?.nama).toList();
    });
  }

  void getInstruktur() async {
    var repository = InstrukturRepository();
    instrukturs = await repository.getInstruktur();
    filterLoginInstruktur();
    setState(() {});
  }
  void getAvailableJadwal() async {
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginInstruktur = appBloc.state.instruktur;
    var repository = InstrukturRepository();
    availableJadwal = await repository.getJadwalByInstruktur(loginInstruktur!.idInstruktur);
    setState(() {});
  }

  @override
Widget build(BuildContext context) {
  return Column(
    children: [
      const Text('Pilih Instruktur Pengganti : '),
      BlocBuilder<IzinBloc,IzinState>(
        builder: (context,state) {
          return Padding(
            padding: const EdgeInsets.all(8.0),
            child: DropdownButton<Instruktur>(
              hint: const Text('Pilih Instruktur Pengganti'),
              value: _selectedOption,
              onChanged: (Instruktur? newValue) async {
                setState(() {
                  _selectedOption = newValue;
                  // var id_instsruktur = newValue!.id_instruktur;
                  context.read<IzinBloc>().add(ValueInstrukturPengganti(instrukturPengganti: _selectedOption!.idInstruktur));
                });
                setState(() {});
              },
              items: instrukturs.map<DropdownMenuItem<Instruktur>>((Instruktur? value) {
                return DropdownMenuItem<Instruktur>(
                  value: value,
                  child: Text(value?.nama ?? 'Pilih Instruktur'),
                );
              }).toList(),
            ),
          );
        }
      ),
    ],
  );
}
}

class ListJadwal extends StatefulWidget {
  final Function(JadwalUmum) onSelect;

  ListJadwal({ required this.onSelect});

  @override
  _ListJadwalState createState() => _ListJadwalState();
}
class _ListJadwalState extends State<ListJadwal> {
  JadwalUmum? _selectedOption;
  late List<JadwalUmum> jadwalUmum = [];
  @override
  void initState() {
    super.initState();
    getJadwalUmum();
  }

  void getJadwalUmum() async {
    var repository = InstrukturRepository();
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginJadwalUmum = appBloc.state.instruktur;
    jadwalUmum = await repository.getJadwalByInstruktur(loginJadwalUmum!.idInstruktur);
    // inspect(jadwalUmum);
    setState(() {});
  }

  @override
Widget build(BuildContext context) {
  return Column(
    children: [
      const Text('Sesi Izin : '),
      BlocBuilder<IzinBloc,IzinState>(
        builder: (context,state) {
          return Padding(
            padding: const EdgeInsets.all(8.0),
            child: DropdownButton<JadwalUmum>(
              hint: const Text('Pilih Jadwal Umum Pengganti'),
              value: _selectedOption,
              onChanged: (JadwalUmum? newValue) async {
                setState(() {
                  _selectedOption = newValue;
                  // var id_instsruktur = newValue!.id_JadwalUmumr;
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
  );
}
}

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
                var waktuIzin = izinBloc.state.tanggalPengajuan;
                // var instruktur = izinBloc.state.idInstrukturPengganti;
                // inspect();
                var idJadwal = izinBloc.state.idJadwalUmum;
                // inspect(idJadwal);
                context.read<IzinBloc>().add(IzinSubmitted(idInstruktur: idInstruktur, idInstrukturPengganti: izinBloc.state.idInstrukturPengganti, idJadwalUmum:  idJadwal));
                _showSnackBar(context, 'Berhasil Izin');
                Navigator.of(context).pop();
              },
              child: Text('Ajukan Ijin')),
            );
        }
      );
      // }),
    // );
  }

    //* Methods
  void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }
  
      // BlocListener<IzinBloc,IzinState>(
      //   listener: (context, state) {
      //     if(state.idJadwalUmum != ''){
      //     }
      //   },
      //   child: Padding(
      //     padding: const EdgeInsets.all(8.0),
      //     child: DropdownButton<JadwalUmum>(
      //       hint: const Text('Jadwal'),
      //       value: _selectdJadwal,
      //       onChanged: (JadwalUmum? newValue) {
      //         setState(() {
      //           _selectdJadwal = newValue;
      
      //         });
      //       },
      //       items: availableJadwal.map<DropdownMenuItem<JadwalUmum>>((JadwalUmum? value) {
      //         return DropdownMenuItem<JadwalUmum>(
      //           value: value,
      //           child: Text(value?.hari ?? 'Pilih Instruktur'),
      //         );
      //       }).toList(),
      //     ),
      //   ),
      // ),
