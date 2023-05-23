import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/kelas.dart';
import 'package:mobile_app_gofit_0541/Models/jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_jadwal_umum.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_kelas.dart';
import 'dart:developer';

class JadwalPage extends StatefulWidget {
  const JadwalPage({super.key});

  @override
  State<JadwalPage> createState() => _JadwalPageState();
}

class _JadwalPageState extends State<JadwalPage> {
  List<JadwalUmum> jadwalUmum = [];
  
  JadwalUmumRepository jadwalUmumRepository = JadwalUmumRepository();
  getJadwal () async{
    jadwalUmum =  await jadwalUmumRepository.getJadwalPublic();
    setState(() {});
  }

  @override
  void initState() {
    super.initState();
    getJadwal();
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Informasi Gofit'),),
      body: SafeArea(
        child: Column(
          children: [
            HeaderTemplate(message: 'Daftar Jadwal'),
            Expanded(
              child: ListView.builder(
                itemCount: jadwalUmum.length,
                itemBuilder: (context, index) => cardJadwal(jadwalUmum[index]),
              ),
            )
          ],
        ),
      ),
    );
  }
}

Widget cardJadwal(JadwalUmum jd){
  return Padding(
    padding: const EdgeInsets.all(8.0),
    child: Card(child: Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.all(8.0),
            child: Text(jd.kelas!.jenisKelas ?? ''),
          ),
          textIcon(jd.hari, Icons.calendar_month),
          textIcon(jd.instruktur!.nama, Icons.person),
          textIcon('${jd.jamMulai} - ${jd.jamSelesai}', Icons.watch_later_outlined),
          textIcon('${jd.kelas!.hargaKelas} ', Icons.money),
          // textIcon('${jd.jamMulai} - ${jd.jamSelesai}', Icons.watch_later_outlined),
        ],
      ),
    )),
  );
}

Widget textIcon(String? text, IconData ic) {
  return Padding(
    padding: const EdgeInsets.all(3.0),
    child: Row(
            children: [
              Icon(ic),
              SizedBox(width: 10),
              Text(text ?? '' ),
            ],
          ),
  );
}
