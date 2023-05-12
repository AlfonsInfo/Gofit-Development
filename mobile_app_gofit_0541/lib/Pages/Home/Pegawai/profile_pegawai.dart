import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';

class ProfilePegawai extends StatelessWidget {
  const ProfilePegawai({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: createAppBar('Profile Pegawai'),
      body: BlocBuilder<AppBloc,AppState>(
        builder: profileViews
      ),
    );
  }

  Widget profileViews(context,state){
      return Center(
        child: Column(
          children: [
            Text('${state.user?.username}'),
            Text('${state.user?.role}')
          ],
        ),
      );
      }
}