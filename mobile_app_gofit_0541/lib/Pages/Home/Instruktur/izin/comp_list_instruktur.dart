
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/ijin_instruktur/izin_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/instruktur.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_instruktur.dart';

//* Dropdown instruktur pengganti
class ListInstruktur extends StatefulWidget {
  final Function(Instruktur) onSelect;
  const ListInstruktur({super.key,  required this.onSelect});

  @override
  ListInstrukturState createState() => ListInstrukturState();
}
class ListInstrukturState extends State<ListInstruktur> {
  Instruktur? _selectedOption;
  late List<Instruktur> instrukturs = [];
  @override
  void initState() {
    super.initState();
    getInstruktur();
  }

  //* Fungsi agar instruktur Login tidak dimasukkan kedalam list Instruktu
  void filterLoginInstruktur()  {
    var appBloc = BlocProvider.of<AppBloc>(context);
    var loginInstruktur = appBloc.state.instruktur;
    setState(() {instrukturs = instrukturs.where((instruktur) => instruktur.nama != loginInstruktur?.nama).toList();});
  }
  
  void getInstruktur() async {
    var repository = InstrukturRepository();
    instrukturs = await repository.getInstruktur();
    filterLoginInstruktur();
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
  return Padding(
      padding: const EdgeInsets.fromLTRB(30,10,30,10),
      child: Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
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
    ),
  );
}
}
