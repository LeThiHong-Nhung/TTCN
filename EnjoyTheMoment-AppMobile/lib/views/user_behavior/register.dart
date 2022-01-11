import 'dart:convert';

import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:fluttertoast/fluttertoast.dart';

class Register extends StatefulWidget {
  const Register({Key key}) : super(key: key);

  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  bool _isObscure1 = true;
  bool _isObscure2 = true;
  final formKey = GlobalKey<FormState>();

  var emailController = TextEditingController();
  var nameController = TextEditingController();
  var passController = TextEditingController();
  var comfirmPassController = TextEditingController();

  Future<void> register() async {
    if (passController.text == comfirmPassController.text) {
      try {
        var response = await http.post(Uri.parse(registerApi), body: {
          "email": emailController.text,
          "name": nameController.text,
          "password": passController.text
        });

        print(response.statusCode);
        var data = jsonDecode(response.body);
        if(data['message'] == "Error Email"){
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Email đã được sử dụng.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.red,
          ));
        } else if(data['message'] == "success"){
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Đăng ký thành công.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.green,
          ));
        }
      } catch (err) {
        print(err);
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Row(
          children: [
            Spacer(),
            Text('Mật khẩu không khớp'),
            Spacer(),
          ],
        ),
        backgroundColor: Colors.red,
      ));
    }
  }

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
                        child: TextFormField(
                          controller: nameController,
                          decoration: InputDecoration(
                              labelText: 'Tên người dùng',
                              hintStyle: TextStyle(color: GreenColor),
                              border: new OutlineInputBorder(
                                  borderSide: BorderSide(color: GreenColor))),
                          style: TextStyle(color: GreenColor, fontSize: 20),
                          validator: (value) {
                            return isValid(value, patternName)
                                ? null
                                : "Nhập vào đúng tên";
                          },
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                        child: Stack(children: [
                          TextFormField(
                            obscureText: _isObscure1,
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
                                      _isObscure1 = !_isObscure1;
                                    });
                                  },
                                  icon: Icon(_isObscure1
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
                        padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                        child: Stack(children: [
                          TextFormField(
                            obscureText: _isObscure2,
                            controller: comfirmPassController,
                            decoration: InputDecoration(
                                labelText: 'Nhập lại mật khẩu',
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
                                      _isObscure2 = !_isObscure2;
                                    });
                                  },
                                  icon: Icon(_isObscure2
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
                            Spacer(),
                            TextButton(
                                onPressed: () => Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => Login(),
                                    )),
                                child: Text(
                                  ' Quay lại đăng nhập',
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
                            print("email: " + emailController.text);
                            print("name: " + nameController.text);
                            print("pass1: " + passController.text);
                            print("pass2: " + comfirmPassController.text);
                            if (formKey.currentState.validate()) {
                              register();
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
                                'Đăng ký',
                                style: TextStyle(
                                    color: Colors.white, fontSize: 20),
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
}
