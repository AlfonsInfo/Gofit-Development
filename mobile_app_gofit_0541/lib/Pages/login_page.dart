import 'package:flutter/material.dart';
import 'package:mobile_app_gofit_0541/Models/login_user.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  LoginResult? loginResult;
  // final _formKey = GlobalKey<FormState>();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // backgroundColor: Color(0xFF6C0604),
      appBar: AppBar(
        title: const Text('Gofit Mobile Apps'),
      ),
      body: SafeArea(
        child: Form(
          // key: ,
          child: Container(
            margin: const EdgeInsets.all(30),
            child: ListView(
              shrinkWrap: true,
              padding: const EdgeInsets.all(20),
              children: [
                logoGofit(context),
                const UsernameField(),
                const PasswordField(),
                const LoginButton(),
                const PublicFeatures(),
                // apiTester()
              ],
            ),
          ),
        ),
      ),
    );
  }

  ElevatedButton apiTester() {
    return ElevatedButton(onPressed: (){
                LoginResult.connectToAPI('yuna', '0541').then((value){
                  loginResult = value;
                  print(loginResult?.message);
                });
              }, child: Text('test'));
  }

  //* Methods
  SizedBox logoGofit(BuildContext context) {
    return SizedBox(
        height: MediaQuery.of(context).size.height * 1 / 3,
        child: Image.asset('assets/images/logo-mobile-apps.png'));
  }
}



//* Username
class UsernameField extends StatelessWidget {
  const UsernameField({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      decoration: const InputDecoration(
        icon: Icon(Icons.person),
        hintText: 'Username /ID Member',
        labelText: 'Name',
      ),
    );
  }
}

//* Password
class PasswordField extends StatelessWidget {
  const PasswordField({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      obscureText: true,
      decoration: const InputDecoration(
        icon: Icon(Icons.password),
        hintText: 'Password',
        labelText: 'Password',
      ),
    );
  }
}

// * Button Login

class LoginButton extends StatelessWidget {
  const LoginButton({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(0, 20, 5, 0),
      child: SizedBox(
        width: double.infinity,
        child: ElevatedButton(
          onPressed: () => {},
          child: const Text('Login'),
          // style: ButtonStyle(
          // backgroundColor: MaterialStateProperty.all(Colors.yellow),
          // ),
        ),
      ),
    );
  }
}


//* Public Features
class PublicFeatures extends StatelessWidget {
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
                  padding:  EdgeInsets.all(4.0),
                  child:  Text("OR"),
                ),
                ),
          ),
          Expanded(child: divider),
        ]),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            iconNav(Icons.calendar_month,'Jadwal'),
            iconNav(Icons.info,'Informasi'),
 ],
        )
      ],
    );
  }

  IconButton iconNav(IconData icon, String tooltipMessage) {
    return IconButton(
            iconSize: 40,
            onPressed: () => {}, icon: Icon(icon,),tooltip: 'Jadwal');
  }
}
