
import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';


//* HomePageMember
class HomePageMember extends StatelessWidget {
  const HomePageMember({super.key});

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('Welcome Buddy'), 
      body: Stack(
        children: [Container(
        height: MediaQuery.of(context).size.height * 1/3,
        decoration: BoxDecoration(
          borderRadius: BorderRadius.only(
        bottomLeft: Radius.circular(15),
        bottomRight: Radius.circular(15),
          ),
          color: ColorApp.colorPrimary,
          border: Border.all(
        width: 2.0,
          ),
        ),
      ),
      Row(
        children: [
            Container(
            width: 50,
            height: 50,
            child: Text('mantap'),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.all(Radius.circular(20)),
              color: Colors.white,
              border: Border.all(
                // width: 5
              )
            ),
          )
        ],
      )
      ]
      ),
      drawer: const SideBar(alamatRoute: '/changepw'),
    );
  }
}
