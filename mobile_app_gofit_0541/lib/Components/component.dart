import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Config/theme_config.dart';

//* AppBar
AppBar createAppBar(String appBar) {
  return AppBar(
title: Text(appBar),
);
}


//* SideBar


//* SideBar satu untuk semua 
class SideBar extends StatelessWidget {
  const SideBar({
    super.key,
    required this.alamatRoute
  });

  final String alamatRoute;

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc,LoginState>(
      builder: (context, state) {
      return Drawer(
      child: Column(
      children: [
        Expanded(
          child: ListView(
            padding: EdgeInsets.zero,
            children: [
              const DrawerHeader(
                decoration: BoxDecoration(
                  color: ColorApp.colorPrimary,
                ),
                child: Text('Gofit',style: TextStyle(color: Colors.white,fontSize: 30)),
              ),
              ListTile(
                leading: const Icon(Icons.person),
                title: const Text('View Profile'),
                onTap: () {
                  Navigator.pushNamed(context, alamatRoute);
                },
              ),
              ListTile(
                leading: const Icon(Icons.security),
                title: const Text('Change Password'),
                onTap: () {
                  Navigator.pushNamed(context, '/changepw');
                },
              ),
              ListTile(
                leading: const Icon(Icons.history_rounded),
                title: const Text('Activities History'),
                onTap: () {
                  Navigator.pop(context);
                },
              ),
            ],
          ),
        ),
        ListTile(
          leading: const Icon(Icons.logout),
          title: const Text('Logout'),
          onTap: () {
            context.read<LoginBloc>()
            .add(Logout());
            Navigator.pushReplacementNamed(context, '/login');                    // Aksi saat tombol Logout di-tap
          },
        ),
      ],
      ),
    );
  }
    );
  }
}



class HeaderTemplate extends StatelessWidget {
  const HeaderTemplate({
    super.key,
    required this.message
  });

  final String message;
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(5,10,5,10),
      child: Text(message, style:  const TextStyle(
        fontSize: 30
      )),
    );
  }
}



