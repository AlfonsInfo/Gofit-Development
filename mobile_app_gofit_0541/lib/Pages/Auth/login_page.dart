// import 'dart:developer';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/app/app_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Pages/Public/public_pricelist_page.dart';
import 'package:mobile_app_gofit_0541/Components/component.dart';


  //* Halaman Login
  class LoginPage extends StatefulWidget {
    const LoginPage({super.key});

    @override
    State<LoginPage> createState() => _LoginPageState();
  }

  //* State halaman login
  class _LoginPageState extends State<LoginPage> {
    LoginResult? loginResult;
    final _formKey = GlobalKey<FormState>();

    @override
    Widget build(BuildContext context) { 
      return Scaffold(
        appBar: createAppBar('Gofit Mobile Apps'), 
        body: _loginForm(context)
      );
    }

  //* Form Login
  Widget _loginForm(BuildContext context) {
    //* BlocListener 
    return BlocListener<LoginBloc,LoginState>(
      listener: (context, state) {
        final formStatus= state.formStatus;
        if(formStatus is SubmissionFailed){
          //* Gagal Login show snackbar
          // _showSnackBar(context, formStatus.exception.toString());
          _showSnackBar(context, 'Gagal Login, Periksa kembali username dan password');
        }
      },
      //*BlocBuilder
      child: BlocBuilder<LoginBloc,LoginState>(
        builder: (context,state){
        return SafeArea(
            child: Form(
              key: _formKey,
              child: Container(
                margin: const EdgeInsets.all(30),
                child: ListView(
                  shrinkWrap: true,
                  padding: const EdgeInsets.all(20),
                  children: [
                    //*core page
                    logoGofit(context),
                    const UsernameField(),
                    const PasswordField(),
                    LoginButton(formkey: _formKey),
                    const PublicFeatures(),
                    //*end core page
                  ],
                ),
              ),
            ),
          );
        }
      ),
    );
  }
  //* Akhir dari state halaman login


  //* Methods
  void _showSnackBar(BuildContext context, String message) {
    final snackBar = SnackBar(content: Text(message));
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }
  
  //* Widget Logo Gofit
  SizedBox logoGofit(BuildContext context) {
    return SizedBox(
      height: MediaQuery.of(context).size.height * 1 / 3,
      child: Image.asset('assets/images/logo-mobile-apps.png'));
  }
}//* Akhir dari class

//* Input Username
class UsernameField extends StatelessWidget {
  const UsernameField({super.key,});

  //* Bloc Builder for the validation
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(builder: (context, state) {
      return TextFormField(
        //* enable jika tidak lagi proses submitting
        enabled: state.formStatus is !FormSubmitting ?,
        //* Styling
        decoration: const InputDecoration(
          icon: Icon(Icons.person),
          hintText: 'Username /ID Member',
          labelText: 'Name',
        ), //*akhir dari styling
        //* validator (cek state)
        validator: (value) => state.isValidUsername ? null : 'invalid username',
        //* setiap perubahan add event
        onChanged: (value) => context.read<LoginBloc>().add(LoginUsernameChanged(username: value)),
      );
    },
    );
  }
}

//* Input Password
class PasswordField extends StatefulWidget {
  const PasswordField({super.key,});

  @override
  State<PasswordField> createState() => _PasswordFieldState();
}

class _PasswordFieldState extends State<PasswordField> {
  bool statusShow = true;
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(builder: (context, state) {
      return TextFormField(
        //* enable jika tidak sedang proses submitting
        enabled: state.formStatus is !FormSubmitting ?,
        //* show / hidden password via eyes
        obscureText: statusShow,
        //*stylign
        decoration:  InputDecoration(
          suffixIcon: eyeIcon(),
          icon: const Icon(Icons.password),
          hintText: 'Password',
          labelText: 'Password',
        ),
        //* akhir dari styling
        //*validasi
        validator: (value) => state.isValidPassword ? null : 'Password is invalid',
        //* mencatat perubahan ke dalam state
        onChanged: (value) => context.read<LoginBloc>().add(LoginPasswordChanged(password: value)),
      );
    });
  }

  IconButton eyeIcon() {
    return IconButton(
          onPressed: () {
            setState(() {
              statusShow = !statusShow;
            });
          },
          icon :  Icon((statusShow) ? Icons.visibility: Icons.visibility_off));
  }
}



  
// * Button Login
class LoginButton extends StatelessWidget {
  const LoginButton({super.key, required this.formkey});

  final GlobalKey<FormState> formkey;
  @override 
  Widget build(BuildContext context) {
    return BlocListener<LoginBloc,LoginState>(
      listener: (context,loginState){
        if(loginState.formStatus is SubmissionSuccess){
            //* jika navigasi sukes navigasi sesuai role (Next)
          context.read<AppBloc>().add(SaveUserInfo(user: loginState.user, instruktur: loginState.instruktur, member: loginState.member));
          (loginState.user?.role == 'member') ? Navigator.pushReplacementNamed(context, '/homeMember') : ' ';
          (loginState.user?.role =='pegawai') ? Navigator.pushReplacementNamed(context, '/homePegawai') : ' ';
          (loginState.user?.role =='instruktur') ? Navigator.pushReplacementNamed(context, '/homeInstruktur') : ' ';
        }
      },
      child: BlocBuilder<LoginBloc, LoginState>(builder: (context, state) {
        return state.formStatus is FormSubmitting
            ? const Center(
                child: Padding(
                  padding: EdgeInsets.only(top: 20),
                    child: CircularProgressIndicator(),
          ),
        )
            : Padding(
                padding: const EdgeInsets.fromLTRB(0, 20, 5, 0),
                child: SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: () => {
                      if(formkey.currentState!.validate()){
                      context.read<LoginBloc>().add(LoginSubmitted()),
                      }
                    },
                    child: const Text('Login'),
                  ),
                ),
              );
      }),
     );
  }
}

//* Public Features
class PublicFeatures extends StatelessWidget {
  //* Constant Constructor
  const PublicFeatures({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    var divider = const Divider(
      color: Colors.black,
      height: 50,
    );
    return Column(
      children: [
        Row(children: <Widget>[
          Expanded(child: divider),
          Padding(
            padding: const EdgeInsets.all(8.0),
            child: Container(
              decoration: BoxDecoration(
                border: Border.all(color: Colors.black),
              ),
              child: const Padding(
                padding: EdgeInsets.all(4.0),
                child: Text("OR"),
              ),
            ),
          ),
          Expanded(child: divider),
        ]),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            iconNav(Icons.calendar_month, 'Jadwal', context, '/jadwalharian'),
            iconNav(Icons.attach_money_outlined , 'Informasi',context, '/pricelist'),
            iconNav(Icons.info , 'Informasi',context, '/menjelajah'),
          ],
        ),
      ],
    );
  }

  IconButton iconNav(IconData icon, String tooltipMessage,BuildContext context , String routeLink) {
    return IconButton(
        iconSize: 40,
        onPressed: () => {
          Navigator.pushNamed(context, routeLink )
        },
        icon: Icon(
          icon,
        ),
        tooltip: tooltipMessage);
  }
}

