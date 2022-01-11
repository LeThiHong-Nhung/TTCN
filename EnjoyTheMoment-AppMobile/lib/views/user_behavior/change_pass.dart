import 'dart:convert';

import 'package:ejm/share/share.dart';
import 'package:ejm/share/valid.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class ChangePass extends StatefulWidget {
  const ChangePass({Key key}) : super(key: key);

  @override
  _ChangePassState createState() => _ChangePassState();
}

class _ChangePassState extends State<ChangePass> {
  final formKey = GlobalKey<FormState>();
  var oldPassController = TextEditingController();
  var newPassController = TextEditingController();
  var newPassComfirmController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: GreenColorAccent,
        elevation: 0.0,
        leading: Container(),
        title: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Spacer(),
            Text('Đổi mật khẩu'),
            Spacer(),
          ],
        ),
        actions: [
          IconButton(
              onPressed: () => Navigator.pop(context),
              icon: Icon(
                Icons.arrow_right,
                size: 30,
              ))
        ],
      ),
      body: SingleChildScrollView(
        child: Form(
          key: formKey,
          child: Container(
            height: MediaQuery.of(context).size.height,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Container(
                  decoration: BoxDecoration(
                    color: GreenColorAccent,
                    borderRadius: BorderRadius.only(
                        bottomLeft: Radius.circular(50),
                        bottomRight: Radius.circular(50)),
                    boxShadow: [
                      BoxShadow(
                        color: GreenColor.withOpacity(0.3),
                        spreadRadius: 0,
                        blurRadius: 5,
                        offset: Offset(0, 10),
                      )
                    ],
                  ),
                  height: MediaQuery.of(context).size.height * 0.25,
                  width: MediaQuery.of(context).size.width,
                  child: Column(
                    children: [
                      Spacer(),
                      Icon(
                        Icons.person,
                        size: 150,
                        color: Colors.white,
                      ),
                      Spacer(),
                    ],
                  ),
                ),
                Spacer(),
                Padding(
                  padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                  child: TextFormField(
                    obscureText: true,
                    controller: oldPassController,
                    decoration: InputDecoration(
                        hintText: 'Mật khẩu cũ',
                        hintStyle: TextStyle(color: GreenColor),
                        border: new OutlineInputBorder(
                            borderSide: BorderSide(color: GreenColor))),
                    validator: (value) {
                      return isValid(value, patternPass)
                          ? null
                          : "Nhập vào đúng mật khẩu";
                    },
                    style: TextStyle(color: GreenColor, fontSize: 20),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                  child: TextFormField(
                    obscureText: true,
                    controller: newPassController,
                    decoration: InputDecoration(
                        hintText: 'Mật khẩu mới',
                        hintStyle: TextStyle(color: GreenColor),
                        border: new OutlineInputBorder(
                            borderSide: BorderSide(color: GreenColor))),
                    validator: (value) {
                      return isValid(value, patternPass)
                          ? null
                          : "Nhập vào đúng mật khẩu";
                    },
                    style: TextStyle(color: GreenColor, fontSize: 20),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.fromLTRB(50, 8, 50, 8),
                  child: TextFormField(
                    obscureText: true,
                    controller: newPassComfirmController,
                    decoration: InputDecoration(
                        hintText: 'Nhập lại mật khẩu mới',
                        hintStyle: TextStyle(color: GreenColor),
                        border: new OutlineInputBorder(
                            borderSide: BorderSide(color: GreenColor))),
                    validator: (value) {
                      return isValid(value, patternPass)
                          ? null
                          : "Nhập vào đúng mật khẩu";
                    },
                    style: TextStyle(color: GreenColor, fontSize: 20),
                  ),
                ),
                TextButton(
                    onPressed: () {
                      if(formKey.currentState.validate()){
                        if(newPassController.text == newPassComfirmController.text){
                          changePass();
                        }
                        else {
                          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                            content: Row(
                              children: [
                                Spacer(),
                                Text('Mật khẩu không khớp.'),
                                Spacer(),
                              ],
                            ),
                            backgroundColor: Colors.red,
                          ));
                        }
                      }
                    },
                    child: Container(
                      height: 50,
                      width: MediaQuery.of(context).size.width * 0.5,
                      decoration: BoxDecoration(
                          color: GreenColor,
                          borderRadius:
                          BorderRadius.all(Radius.circular(10))),
                      child: Center(
                        child: Text(
                          'Thay đổi mật khẩu',
                          style: TextStyle(color: Colors.white, fontSize: 20),
                        ),
                      ),
                    )),
                Spacer(),
              ],
            ),
          ),
        ),
      ),
    );
  }
  Future changePass() async {
    try {
      var response = await http.post(Uri.parse('https://quanlitourejm.000webhostapp.com/api/auth/changepassword.php'), body: {
        "email": EMAIL,
        "oldPass": oldPassController.text,
        "newPass": newPassController.text,
      });

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        if (data['message'] == 'successful') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Đổi mật khẩu thành công.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.green,
          ));
          return Navigator.pop(context);
        }
        if (data['message'] == 'incorrect') {
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
        if (data['message'] == 'update fail') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Lỗi cập nhập dữ liệu.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.red,
          ));
        }
      }
    } catch (err) {
      print(err);
    }
  }
}
