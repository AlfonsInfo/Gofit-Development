import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Components/component_1.dart';

class ChangePasswordPage extends StatefulWidget {
  const ChangePasswordPage({super.key});

  @override
  State<ChangePasswordPage> createState() => _ChangePasswordPageState();
}

class _ChangePasswordPageState extends State<ChangePasswordPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: createAppBar('Change Password'),
      body: Center(
        child: Form(child: 
          Column(
            children: [
              Spacer(flex: 1),
              formpwLama(),
              formpwBaru(),
              btnGantiPw(),
              Spacer(flex: 1),

            ],
          ),
        ),
      ),
    );
  }

  Widget btnGantiPw() {
    return Padding(
            padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: ElevatedButton(onPressed: (){}, child: Text('Ganti Password'))
          );
  }

  Widget formpwBaru() {
    return Padding(
              padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
              child: TextFormField(
                obscureText: true,
                enabled: true,
                decoration: InputDecoration(
                  label: Text('Password baru')
                ),
              ),
            );
  }

  Widget formpwLama() {
    return Padding(
              padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
              child: TextFormField(
                obscureText: true,
                enabled: true,
                decoration: InputDecoration(
                  label: Text('Password lama')
                ),
              ),
            );
  }
}