import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/reset/reset_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';

class ChangePasswordPage extends StatefulWidget {
  const ChangePasswordPage({super.key});

  @override
  State<ChangePasswordPage> createState() => _ChangePasswordPageState();
}

class _ChangePasswordPageState extends State<ChangePasswordPage> {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<AppBloc,AppState>(
      builder: (context,state){
        return Scaffold(
          appBar: createAppBar('Change Password'),
          body: BlocProvider(
            create: (context) => ResetBloc(),
            child: Center(
              child: BlocListener<ResetBloc,ResetState>(
                listener: (context, state) {
                  final formStatus = state.formStatus;
                  if (formStatus is SubmissionSuccess) {
                      ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text('Password berhasil diubah')),
                  );
                  } else if (formStatus is SubmissionSuccess) {
                      ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text('Password gagal diubah')),
                    );
                  }
                },
                child: Form(child: 
                  Column(
                    children: [
                      // Text('${state.user?.idPengguna}'),
                      const Spacer(flex: 1),
                      formpwLama(),
                      formpwBaru(),
                      btnGantiPw(),
                      const Spacer(flex: 1),
                    ],
                  ),
                ),
              ),
            ),
          ),
        );
      }
    );
  }

  Widget btnGantiPw() {
    return BlocBuilder<ResetBloc,ResetState>(
      builder: ((context, state) {
      return Padding(
        padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
        child: ElevatedButton(
          onPressed: (){
            var appBloc = context.read<AppBloc>();
            var idPengguna = appBloc.state.user?.idPengguna;
            context.read<ResetBloc>().add(ResetSubmitted(idPengguna: idPengguna ));
          },
          child: Text('Ganti Password')),
        );
      }),
    );
  }

  Widget formpwBaru() {
    return BlocBuilder<ResetBloc,ResetState>(builder: (context, state) {
      return  Padding(
          padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: TextFormField(
              obscureText: true,
              enabled: true,
              decoration: InputDecoration(
                label: Text('Password baru')
              ),
              onChanged: (value) => context.read<ResetBloc>().add(newPasswordChanged(password: value)),
            ),
          );
      }, );
  }
  Widget formpwLama() {
    return BlocBuilder<ResetBloc,ResetState>(builder: (context, state) {
      return  Padding(
          padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: TextFormField(
              obscureText: true,
              enabled: true,
              decoration: InputDecoration(
                label: Text('Password Lama')
              ),
              onChanged: (value) => context.read<ResetBloc>().add(OldPasswordChanged(oldPw: value)),
            ),
          );
      }, );
  }


}