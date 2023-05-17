import 'dart:developer';

import 'package:flutter/src/widgets/framework.dart';
import 'package:flutter/src/widgets/placeholder.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_sesi.dart';

class MyWidget extends StatefulWidget {
  const MyWidget({super.key});

  @override
  State<MyWidget> createState() => _MyWidgetState();
}

class _MyWidgetState extends State<MyWidget> {

  @override
  void setState(VoidCallback fn) {
    // TODO: implement setState
    SesiRepository  sesiRepo = SesiRepository();
    sesiRepo.getSesi();
    inspect(sesiRepo);
  }  
  @override
  Widget build(BuildContext context) {
    return const Placeholder();
  }
}