
import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component_1.dart';


//* HomePageMember
class HomePageMember extends StatelessWidget {
  const HomePageMember({super.key});

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: createAppBar('Welcome Buddy'), 
      drawer: const SideBar(),
    );
  }
}
