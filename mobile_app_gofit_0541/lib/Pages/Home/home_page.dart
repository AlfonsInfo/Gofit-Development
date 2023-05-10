import 'package:flutter/material.dart';
import 'package:flutter/src/widgets/framework.dart';
import 'package:flutter/src/widgets/placeholder.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';

//* HomePagePegawai
class HomePagePegawai extends StatelessWidget {
  const HomePagePegawai({super.key});

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: AppBar(title: const Text('Welcome MO'),),
      body: ListView(
        children: [
        headerTemplate(message: 'Kelas Hari ini'),
        classCard('SPINE Corrector'),        
        classCard('Muaythai'),        
        classCard('BUNGEE'),        
        classCard('Building Up'),        
        classCard('Building Up'),        
        classCard('Building Up'),        
        classCard('Building Up'),        
      ],
      ),
      // bottomNavigationBar: BottomNavigationBar(
      //   items: const [
      //     BottomNavigationBarItem(
      //       icon: Icon(Icons.sports_gymnastics),
      //       label : 'Kelas'
      //       ),
      //   ]),
    );
  }

  Widget classCard(String title) {
    return Padding(
      padding: const EdgeInsets.all(4.0),
      child: Card(
          child: ListTile(
            leading: FlutterLogo(size: 72.0),
            title: Text(title),
            subtitle:
                Text('A sufficiently long subtitle warrants three lines.'),
            trailing: Icon(Icons.more_vert),
            isThreeLine: true,
          ),
        ),
    );
  }
}

class headerTemplate extends StatelessWidget {
  const headerTemplate({
    super.key,
    required this.message
  });

  final String message;
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(5,10,5,10),
      child: Text(message, style:  TextStyle(
        fontSize: 30
      )),
    );
  }
}





//* HomePageMember
class HomePageMember extends StatelessWidget {
  const HomePageMember({super.key});

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: AppBar(title: const Text('Welcome To Gofit`s Home '),),
    );
  }
}


//* HomePageInstruktur
class HomePageInstruktur extends StatelessWidget {
  const HomePageInstruktur({super.key});
  @override
  Widget build(BuildContext context) {
  final widthBox = MediaQuery.of(context).size.width * 0.9;
  final heightBox = MediaQuery.of(context).size.height * 0.3;
    return  Scaffold(
      appBar: AppBar(title: const Text('Welcome Instructure'),),
      body: ListView(
        children:
        [
        headerTemplate(message: 'Selamat Datang Instruktur',),
        Center(
          child: Container(
            width: widthBox,
            height: heightBox,
            decoration: BoxDecoration(
              border: Border.all(
                color: ColorApp.colorPrimary,
                width: 4,
                style: BorderStyle.solid,
              ),
              borderRadius: BorderRadius.circular(10.0),
            ),
            child: Padding(
              padding: const EdgeInsets.all(20.0),
              child: Row(
                children: [
                  Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Column(
                      children: [
                        IconButton(onPressed: (){}, icon: Icon(Icons.mail),tooltip: 'Ijin',),
                        Text('Ijin')
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Column(
                      children: [
                        IconButton(onPressed: (){}, icon: Icon(Icons.history),tooltip: 'Izin Instruktur',),
                        Text('Riwayat Ijin')
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Column(
                      children: [
                        IconButton(onPressed: (){}, icon: Icon(Icons.check_box_outlined),tooltip: 'Izin Instruktur',),
                        Text('Presensi Kelas')
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ]
      ),
    );
  }
}

