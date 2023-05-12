import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component_1.dart';
import 'package:intl/intl.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/instruktur.repository.dart';
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
    return  Scaffold(
      appBar: createAppBar('Form Perijinan Instruktur'),
      body: Column(
        children: [
          const HeaderTemplate(message: 'Perijinan Instruktur :'),
          Form(child: Column(
            children: [
              fieldNama(),
              fieldTanggal(stringDate),
              listInstrukturPengganti(
                  onSelect: (Instruktur selected) => setState(() {}),
                ),             
              btnIjin()
            ],
          ))
        ],
      ),
    );
  }

  Padding fieldTanggal(String stringDate) {
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

  Padding fieldNama() {
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

class listInstrukturPengganti extends StatefulWidget {
  final Function(Instruktur) onSelect;

  listInstrukturPengganti({ required this.onSelect});

  @override
  _listInstrukturPenggantiState createState() => _listInstrukturPenggantiState();
}
class _listInstrukturPenggantiState extends State<listInstrukturPengganti> {
  Instruktur? _selectedOption;
  JadwalUmum? _selectdJadwal;
  late List<Instruktur> instrukturs = [];
  late List<JadwalUmum> availableJadwal = [];
  @override
  void initState() {
    super.initState();
    getInstruktur();
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
  Future<List<JadwalUmum>> getAvailableJadwal(String id_instruktur) async {
    var repository = InstrukturRepository();
    return  availableJadwal = await repository.getJadwalByInstruktur(id_instruktur);
  }

  @override
Widget build(BuildContext context) {
  return Column(
    children: [
      Text('Pilih Instruktur Pengganti : '),
      Padding(
        padding: const EdgeInsets.all(8.0),
        child: DropdownButton<Instruktur>(
          hint: Text('Pilih Instruktur Pengganti'),
          value: _selectedOption,
          onChanged: (Instruktur? newValue) async {
            setState(() {
              _selectedOption = newValue;
            });
            availableJadwal = await getAvailableJadwal(_selectedOption!.idPengguna!);
            // inspect(availableJadwal);
            setState(() {});
          },
          items: instrukturs.map<DropdownMenuItem<Instruktur>>((Instruktur? value) {
            return DropdownMenuItem<Instruktur>(
              value: value,
              child: Text(value?.nama ?? 'Pilih Instruktur'),
            );
          }).toList(),
        ),
      ),
      Padding(
        padding: const EdgeInsets.all(8.0),
        child: DropdownButton<JadwalUmum>(
          hint: Text('Jadwal'),
          value: _selectdJadwal,
          onChanged: (JadwalUmum? newValue) {
            setState(() {
              _selectdJadwal = newValue;
            });
          },
          items: availableJadwal.map<DropdownMenuItem<JadwalUmum>>((JadwalUmum? value) {
            return DropdownMenuItem<JadwalUmum>(
              value: value,
              child: Text(value?.hari ?? 'Pilih Instruktur'),
            );
          }).toList(),
        ),
      ),
    ],
  );
}
}

  Widget btnIjin() {
  //  return BlocBuilder<ResetBloc,ResetState>(
      // builder: ((context, state) {
      return Padding(
        padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
        child: ElevatedButton(
          onPressed: (){
            // var appBloc = context.read<AppBloc>();
            // var idPengguna = appBloc.state.user?.idPengguna;
            // context.read<ResetBloc>().add(ResetSubmitted(idPengguna: idPengguna ));
          },
          child: Text('Ajukan Ijin')),
        );
      // }),
    // );
  }
