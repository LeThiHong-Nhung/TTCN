import 'dart:convert';

import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/home/home.dart';
import 'package:ejm/views/user_behavior/forget_pass.dart';
import 'package:ejm/views/user_behavior/register.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class Login extends StatefulWidget {
  const Login({Key key}) : super(key: key);

  @override
  _LoginState createState() => _LoginState();
}

class _LoginState extends State<Login> {
  bool _isObscure = true;
  final formKey = GlobalKey<FormState>();

  var emailController = TextEditingController();
  var passController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Container(
          color: GreenColor,
          height: MediaQuery.of(context).size.height,
          width: MediaQuery.of(context).size.width,
          child: Stack(
            children: [
              Container(
                height: MediaQuery.of(context).size.height,
                width: MediaQuery.of(context).size.width,
                decoration: BoxDecoration(
                    color: Colors.green.shade100,
                    borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(200),
                        bottomRight: Radius.circular(200))),
              ),
              Container(
                height: MediaQuery.of(context).size.height,
                width: MediaQuery.of(context).size.width,
                decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(250),
                        bottomRight: Radius.circular(250))),
              ),
              Container(
                width: MediaQuery.of(context).size.width,
                child: Form(
                  key: formKey,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Spacer(),
                      Image.asset('images/logo_200x200.png'),
                      Padding(
                        padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                        child: TextFormField(
                          controller: emailController,
                          decoration: InputDecoration(
                              labelText: 'Email',
                              hintStyle: TextStyle(color: GreenColor),
                              border: new OutlineInputBorder(
                                  borderSide: BorderSide(color: GreenColor))),
                          style: TextStyle(color: GreenColor, fontSize: 20),
                          validator: (value) {
                            return isValid(value, patternEmail)
                                ? null
                                : "Nhập vào đúng địa chỉ email";
                          },
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                        child: Stack(children: [
                          TextFormField(
                            obscureText: _isObscure,
                            controller: passController,
                            decoration: InputDecoration(
                                labelText: 'Mật khẩu',
                                hintStyle: TextStyle(color: GreenColor),
                                border: new OutlineInputBorder(
                                    borderSide: BorderSide(color: GreenColor))),
                            style: TextStyle(color: GreenColor, fontSize: 20),
                            validator: (value) {
                              return isValid(value, patternPass)
                                  ? null
                                  : "Nhập vào đúng mật khẩu";
                            },
                          ),
                          Row(
                            children: [
                              Spacer(),
                              Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: IconButton(
                                  onPressed: () {
                                    setState(() {
                                      _isObscure = !_isObscure;
                                    });
                                  },
                                  icon: Icon(_isObscure
                                      ? Icons.visibility
                                      : Icons.visibility_off),
                                  color: Colors.black45,
                                ),
                              )
                            ],
                          )
                        ]),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(left: 50, right: 50),
                        child: Row(
                          children: [
                            TextButton(
                                onPressed: () => Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => ForgetPass(),
                                    )),
                                child: Text(
                                  'Quên mật khẩu',
                                  style: TextStyle(
                                      color: Colors.blueAccent,
                                      fontStyle: FontStyle.italic,
                                      fontSize: 15),
                                )),
                            Spacer(),
                            TextButton(
                                onPressed: () => Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => Register(),
                                    )),
                                child: Text(
                                  'Đăng kí người dùng mới',
                                  style: TextStyle(
                                      color: Colors.blueAccent,
                                      fontStyle: FontStyle.italic,
                                      fontSize: 15),
                                )),
                          ],
                        ),
                      ),
                      TextButton(
                          onPressed: () {
                            if (formKey.currentState.validate()) {
                              login();
                            }
                          },
                          child: Container(
                            height: 50,
                            width: MediaQuery.of(context).size.width * 0.3,
                            decoration: BoxDecoration(
                                color: GreenColor,
                                borderRadius:
                                    BorderRadius.all(Radius.circular(10))),
                            child: Center(
                              child: Text(
                                'Đăng nhập',
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize:
                                      MediaQuery.of(context).size.width * 0.05,
                                ),
                              ),
                            ),
                          )),
                      Spacer(),
                    ],
                  ),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }

  Future login() async {
    try {
      var response = await http.post(Uri.parse(loginApi), body: {
        "email": emailController.text,
        "password": passController.text
      });

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        if (data['message'] == 'success') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Đăng nhập thành công.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.green,
          ));
          print(data['result']);
          USERNAME = data['result']['tennguoidung'];
          EMAIL = data['result']['madangnhap'];

          return Navigator.push(context, MaterialPageRoute(builder: (context) => MyHomePage(),));
        }
        if (data['message'] == 'password error') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Mật khẩu không đúng!'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.red,
          ));
        }
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('Sai Email hoặc mật khẩu.'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.red,
        ));
      }
    } catch (err) {
      print(err);
    }

    // print(await http.read(Uri.parse('https://example.com/foobar.txt')));
  }
}
