import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';
import 'package:mobile_app_gofit_0541/Repository/auth_repository.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/form_submission_status.dart';
import 'package:mobile_app_gofit_0541/Bloc/login/login_bloc.dart';
import 'package:mobile_app_gofit_0541/Pages/Public/public_page.dart';
import 'package:mobile_app_gofit_0541/Pages/Home/home_page.dart';


// //* Main Login 
// class MainLogin extends StatelessWidget {
//   const MainLogin({super.key});

//   @override
//   Widget build(BuildContext context) {
//     return RepositoryProvider(
//       create: (_) => AuthRepository(),
//       child : const  LoginPage()); 
//   }
// }

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}
//*provider
  //*block builder

class _LoginPageState extends State<LoginPage> {
  LoginResult? loginResult;
  final _formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) { 
    return Scaffold(
      appBar: AppBar(title: const Text('Gofit Mobile Apps'),),
      body: BlocProvider(
        create: (context) => LoginBloc(),
        child: _loginForm(context),
      ),
    );
  }

  Widget _loginForm(BuildContext context) {
    return BlocListener<LoginBloc,LoginState>(
      listener: (context, state) {
        final formStatus= state.formStatus;
        if(formStatus is SubmissionFailed){
          _showSnackBar(context, formStatus.exception.toString());
        }
      },
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
                    logoGofit(context),
                    UsernameField(),
                    const PasswordField(),
                    LoginButton(formkey: _formKey),
                    const PublicFeatures(),
                    // apiTester()
                  ],
                ),
              ),
            ),
          );
        }
      ),
    );

  }

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

}

//* Input Username
class UsernameField extends StatelessWidget {
  const UsernameField({super.key,});

  //* Bloc Builder for the validation
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(builder: (context, state) {
      return TextFormField(
        enabled: state.formStatus is !FormSubmitting ?,
        decoration: const InputDecoration(
          icon: Icon(Icons.person),
          hintText: 'Username /ID Member',
          labelText: 'Name',
        ),
        validator: (value) => state.isValidUsername ? null : 'invalid username',
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
        enabled: state.formStatus is !FormSubmitting ?,
        obscureText: statusShow,
        decoration:  InputDecoration(
          suffixIcon: IconButton(
            onPressed: () {
              setState(() {
                statusShow = !statusShow;
              });
            },
            icon :  Icon((statusShow) ? Icons.visibility: Icons.visibility_off)),
          icon: const Icon(Icons.password),
          hintText: 'Password',
          labelText: 'Password',
        ),
        validator: (value) =>
            state.isValidPassword ? null : 'Password is invalid',
        onChanged: (value) => context
            .read<LoginBloc>()
            .add(LoginPasswordChanged(password: value)),
      );
    });
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
          if(loginState.role == 'member'){
            Navigator.push(context, MaterialPageRoute(builder: (context) => HomePageMember()));        
          }
          if(loginState.role =='pegawai'){
            Navigator.push(context, MaterialPageRoute(builder: (context) => HomePagePegawai()));        
          }
          if(loginState.role =='instruktur'){
            Navigator.push(context, MaterialPageRoute(builder: (context) => HomePageInstruktur()));        
          }
        }
      },
      child: BlocBuilder<LoginBloc, LoginState>(builder: (context, state) {
        return state.formStatus is FormSubmitting
            ? const Center(
                child: Padding(
                  padding: const EdgeInsets.only(top: 20),
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
                    // style: ButtonStyle(
                    // backgroundColor: MaterialStateProperty.all(Colors.yellow),
                    // ),
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
            iconNav(Icons.calendar_month, 'Jadwal', context),
            iconNav(Icons.info, 'Informasi',context),
          ],
        ),
      ],
    );
  }

  IconButton iconNav(IconData icon, String tooltipMessage,BuildContext context) {
    return IconButton(
        iconSize: 40,
        onPressed: () => {
          Navigator.push(context, MaterialPageRoute(builder: (context) => const PublicPage() ))
        },
        icon: Icon(
          icon,
        ),
        tooltip: 'Jadwal');
  }
}



//  //* Method Untuk Testing API
//   ElevatedButton apiTester() {
//     return ElevatedButton(
//       onPressed: () {
//         LoginResult.connectToAPI('yuna', '0541').then((value) {
//           loginResult = value;
//           // print(loginResult?.message);
//         });
//       },
//       child: const Text('Test Api'),
//     );
//   }
