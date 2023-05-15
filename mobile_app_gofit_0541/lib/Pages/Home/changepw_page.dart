import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
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
                      const SnackBar(content: Text('Password berhasil diubah')),
                  );
                  } else if (formStatus is SubmissionSuccess) {
                      ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text('Password gagal diubah')),
                    );
                  }
                },
                child: Form(child: 
                  Column(
                    children: [
                      // Text('${state.user?.idPengguna}'),
                      const Spacer(flex: 1),
                      const FieldOldPassword(),
                      const FieldNewPassword(),
                      // FieldConfirmNewPassword(),
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


  //* Button Ganti Password
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

  //* Input Text Pw Baru


}

class FieldOldPassword extends StatefulWidget {
  const FieldOldPassword({
    super.key,
  });

  @override
  State<FieldOldPassword> createState() => _FieldOldPasswordState();
}

class _FieldOldPasswordState extends State<FieldOldPassword> {
  bool statusShow = true;

  IconButton eyeIcon() {
    return IconButton(
          onPressed: () {
            setState(() {
              statusShow = !statusShow;
            });
          },
          icon :  Icon((statusShow) ? Icons.visibility: Icons.visibility_off));
  }


  @override
  Widget build(BuildContext context) {
    return BlocBuilder<ResetBloc,ResetState>(builder: (context, state) {
      return  Padding(
          padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: TextFormField(
              obscureText: statusShow,
              enabled: true,
              decoration: InputDecoration(
                label: Text('Password Lama'),
                suffixIcon: eyeIcon()
              ),
              onChanged: (value) => context.read<ResetBloc>().add(OldPasswordChanged(oldPw: value)),
            ),
          );
      }, );
  }
}

class FieldNewPassword extends StatefulWidget {
  const FieldNewPassword({
    super.key,
  });

  @override
  State<FieldNewPassword> createState() => _FieldNewPasswordState();
}

class _FieldNewPasswordState extends State<FieldNewPassword> {
  bool statusShow = true;
  //* Method
    IconButton eyeIcon() {
    return IconButton(
          onPressed: () {
            setState(() {
              statusShow = !statusShow;
            });
          },
          icon :  Icon((statusShow) ? Icons.visibility: Icons.visibility_off));
    }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<ResetBloc,ResetState>(builder: (context, state) {
      return  Padding(
          padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: TextFormField(
              obscureText: statusShow ,
              enabled: true,
              decoration: InputDecoration(
                label: Text('Password baru'),
                suffixIcon: eyeIcon()
              ),
              onChanged: (value) => context.read<ResetBloc>().add(newPasswordChanged(password: value)),
            ),
          );
      }, );
  }
}



class FieldConfirmNewPassword extends StatefulWidget {
  const FieldConfirmNewPassword({
    super.key,
  });

  @override
  State<FieldConfirmNewPassword> createState() => _FieldConfirmNewPasswordState();
}

class _FieldConfirmNewPasswordState extends State<FieldConfirmNewPassword> {
  bool statusShow = true;
  //* Method
    IconButton eyeIcon() {
    return IconButton(
          onPressed: () {
            setState(() {
              statusShow = !statusShow;
            });
          },
          icon :  Icon((statusShow) ? Icons.visibility: Icons.visibility_off));
    }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<ResetBloc,ResetState>(builder: (context, state) {
      return  Padding(
          padding: const EdgeInsets.fromLTRB(30, 10, 30, 10),
            child: TextFormField(
              obscureText: statusShow ,
              enabled: true,
              decoration: InputDecoration(
                label: Text('Password baru'),
                suffixIcon: eyeIcon()
              ),
              onChanged: (value) => context.read<ResetBloc>().add(confirmPasswordChanged(password: value)),
              validator: (value) => state.isNotSame? 'Sama' : 'Tidak',
            ),
          );
      }, );
  }
}