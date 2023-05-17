import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';

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
        child: Column(
          children: [
            HeaderTemplate(message: 'Class Pricelist')
            // ListView.builder(itemBuilder: itemBuilder)
          ],
        ),
      ),
    );
  }
}