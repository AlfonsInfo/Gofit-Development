import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component_1.dart';
import 'package:mobile_app_gofit_0541/Models/ijin_instruktur.dart';
import 'package:mobile_app_gofit_0541/Repository/ijin_repository.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
class RiwayatIjinPage extends StatefulWidget {
  const RiwayatIjinPage({Key? key}) : super(key: key);

  @override
  State<RiwayatIjinPage> createState() => _RiwayatIjinPageState();
}

class _RiwayatIjinPageState extends State<RiwayatIjinPage> {
  late List<IjinInstruktur> ijinInstruktur = [];

  @override
  void initState() {
    super.initState();
    getIjinInstruktur();
  }

  void getIjinInstruktur() async {
    var repository = IjinRepository();
    var appBloc = BlocProvider.of<AppBloc>(context);
    var idInstruktur = appBloc.state.instruktur?.idInstruktur;
    if (idInstruktur != null) {
      ijinInstruktur = await repository.getIjinInstruktur(idInstruktur);
      setState(() {});
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: createAppBar('Riwayat Ijin'),
      body: ListView.builder(
        itemCount: ijinInstruktur.length,
        itemBuilder: (context, index) {
          return Card(
            child: ListTile(
              title: Text(ijinInstruktur[index].idIjin ?? ''),
              subtitle: Text(ijinInstruktur[index].statusIjin ?? ''),
            ),
          );
        },
      ),
    );
  }
}
