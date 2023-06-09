import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/izin_instruktur.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_ijin_instruktur.dart';
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
              title: Text('#${ijinInstruktur[index].idIjin} - Tanggal pengajuan ${ijinInstruktur[index].tanggalPengajuan}'  ),
              subtitle: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Text(ijinInstruktur[index].statusIjin ?? ''),
                  Text('Ijin pada ${ijinInstruktur[index].jadwalHarian?.tanggal} kelas : ${ijinInstruktur[index].jadwalHarian?.jadwalUmum?.kelas?.jenisKelas} '),
                  Text('Kode instruktur pengganti : ${ijinInstruktur[index].instrukturPengganti}')
                ],
              ),
            ),
          );
        },
      ),
    );
  }
}
