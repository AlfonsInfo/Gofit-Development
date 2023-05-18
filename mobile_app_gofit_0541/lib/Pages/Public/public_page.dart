import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Models/kelas.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_kelas.dart';
import 'dart:developer';

class PublicPage extends StatefulWidget {
  const PublicPage({super.key});

  @override
  State<PublicPage> createState() => _PublicPageState();
}

class _PublicPageState extends State<PublicPage> {
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Informasi Gofit'),),
      body: SafeArea(
        child: ListView(
          children: const [
            HeaderTemplate(message: 'Class Pricelist'),
            TablePriceList()
          ],
        ),
      ),
    );
  }
}


class TablePriceList extends StatefulWidget {
  const TablePriceList({super.key});

  @override
  State<TablePriceList> createState() => _TablePriceListState();
}

class _TablePriceListState extends State<TablePriceList> {
  final kelasRepository = KelasRepository();
    List<Kelas> listKelas = [];
    List labelTabel = ['No','Nama Kelas', 'Harga'];
    @override
    initState(){
      super.initState();
      getKelas();
    }


    
    getKelas () async{
      listKelas=  await kelasRepository.show();
      inspect(listKelas);
      setState(() {});
    }
    

  
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(20.0),
      child: DataTable(
        columns: List.generate(labelTabel.length, (index) => headerTable(labelTabel[index])),
         rows: List.generate(
          listKelas.length,
          (index) => rowKelas(index + 1, listKelas[index]),
        ),
      ),
    );
  }

  DataColumn headerTable(String labelTabel){
    return DataColumn(
          label: Expanded(
            child: Text(
              labelTabel,
              style: const TextStyle(fontStyle: FontStyle.italic),
            ),
          ),
        );
  }

  DataRow rowKelas(int index, Kelas kelas) {
    return DataRow(
        cells: <DataCell>[
          DataCell(Text('$index')),
          DataCell(Text('${kelas.jenisKelas}')),
          DataCell(Text('${kelas.hargaKelas}')),
        ],
      );
  }
}


// const <DataRow[
//         DataRow(
//           cells: <DataCell>[
//             DataCell(Text('Sarah')),
//             DataCell(Text('19')),
//             // DataCell(Text('Student')),
//           ],
//         ),

// * traditional way wkwkw
      //   rows: 
      //    <DataRow>[
      //     for(var item in listKelas)
      //     rowKelas(item),]