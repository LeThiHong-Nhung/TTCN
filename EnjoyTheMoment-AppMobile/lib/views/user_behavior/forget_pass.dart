import 'dart:convert';

import 'package:ejm/share/share.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class ForgetPass extends StatefulWidget {
  const ForgetPass({Key key}) : super(key: key);

  @override
  _ForgetPassState createState() => _ForgetPassState();
}

class _ForgetPassState extends State<ForgetPass> {
  bool _VerifyCode = true;
  final formKey = GlobalKey<FormState>();
  String code;
  var emailController = TextEditingController();
  var codeController = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Form(
          key: formKey,
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
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Spacer(),
                      Image.asset('images/logo_200x200.png'),
                      Padding(
                        padding: const EdgeInsets.only(left: 10, right: 10),
                        child: Text(
                          'Nh???p v??o ?????a ch??? Email ????? nh???n ???????c m?? x??c nh???n c???a h??? th???ng sau ???? x??c nh???n m?? x??c nh???n ????? nh???n ???????c email m???i',
                          style: TextStyle(
                              color: Colors.black45,
                              fontStyle: FontStyle.italic,
                              fontSize: 18),
                        ),
                      ),
                      SizedBox(
                        height: 10,
                      ),
                      _VerifyCode
                          ? Column(
                              children: [
                                Padding(
                                  padding:
                                      const EdgeInsets.only(left: 10, right: 10),
                                  child: Row(
                                    children: [
                                      Text(
                                        'Email',
                                        style: TextStyle(
                                            color: Colors.blueAccent,
                                            fontStyle: FontStyle.italic,
                                            fontSize: 18),
                                      ),
                                      Spacer(),
                                    ],
                                  ),
                                ),
                                Padding(
                                  padding:
                                      const EdgeInsets.fromLTRB(10, 5, 10, 8),
                                  child: TextFormField(
                                    controller: emailController,
                                    validator: (value) {
                                      return isValid(value, patternEmail)
                                          ? null
                                          : "Nh???p v??o ????ng ?????a ch??? email";
                                    },
                                    decoration: InputDecoration(
                                        hintText: '',
                                        hintStyle: TextStyle(color: GreenColor),
                                        border: new OutlineInputBorder(
                                            borderSide:
                                                BorderSide(color: GreenColor))),
                                    style: TextStyle(
                                        color: GreenColor, fontSize: 20),
                                  ),
                                ),
                              ],
                            )
                          : Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Row(
                                children: [
                                  Container(
                                    width:
                                        MediaQuery.of(context).size.width * 0.4,
                                    child: Text(
                                      'Nh???p m?? x??c nh???n',
                                      style: TextStyle(
                                          color: Colors.blueAccent,
                                          fontStyle: FontStyle.italic,
                                          fontSize: 18),
                                    ),
                                  ),
                                  Spacer(),
                                  Container(
                                    width:
                                        MediaQuery.of(context).size.width * 0.5,
                                    child: Padding(
                                      padding:
                                          const EdgeInsets.fromLTRB(10, 5, 10, 8),
                                      child: TextFormField(
                                        controller: codeController,
                                        decoration: InputDecoration(
                                            hintText: '* * * * * *',
                                            hintStyle:
                                                TextStyle(color: GreenColor),
                                            border: new OutlineInputBorder(
                                                borderSide: BorderSide(
                                                    color: GreenColor))),
                                        style: TextStyle(
                                            color: GreenColor, fontSize: 20),
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                      TextButton(
                          onPressed: () {
                            setState(() {
                              if(_VerifyCode){
                                if(formKey.currentState.validate()){
                                  sendEmail();
                                }
                              } else {
                                if(codeController.text == code){
                                  getNewPass();
                                } else {
                                  return ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                                    content: Row(
                                      children: [
                                        Spacer(),
                                        Text('M?? x??c nh???n kh??ng ????ng.'),
                                        Spacer(),
                                      ],
                                    ),
                                    backgroundColor: Colors.red,
                                  ));
                                }
                              }
                            });
                          },
                          child: Container(
                            height: 50,
                            width: MediaQuery.of(context).size.width,
                            decoration: BoxDecoration(
                                color: GreenColor,
                                borderRadius:
                                    BorderRadius.all(Radius.circular(10))),
                            child: Center(
                              child: Text(
                                _VerifyCode
                                    ? 'Nh???n m?? x??c nh???n'
                                    : 'X??c nh???n code',
                                style:
                                    TextStyle(color: Colors.white, fontSize: 20),
                              ),
                            ),
                          )),
                      Spacer(),
                      TextButton(
                        onPressed: () => Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => Login(),
                            )),
                        child: Text(
                          'Quay l???i trang ????ng nh??p',
                          style: TextStyle(
                              color: Colors.blueAccent,
                              fontStyle: FontStyle.italic,
                              fontSize: 18),
                        ),
                      ),
                      SizedBox(
                        height: 30,
                      )
                    ],
                  ),
                )
              ],
            ),
          ),
        ),
      ),
    );
  }

  Future sendEmail() async {
    try {
      var response = await http.post(Uri.parse('https://quanlitourejm.000webhostapp.com/api/auth/forgot.php'), body: {
        "email": emailController.text,
      });

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        setState(() {
          code = data['message'];
          _VerifyCode = !_VerifyCode;
        });
      }
    } catch (err) {
      print(err);
    }

    // print(await http.read(Uri.parse('https://example.com/foobar.txt')));
  }
  Future getNewPass() async {
    try {
      var response = await http.post(Uri.parse('https://quanlitourejm.000webhostapp.com/api/auth/get_new_pass.php'), body: {
        "email": emailController.text,
      });

      if (response.statusCode == 200) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('M???t kh???u m???i ???? ???????c g???i ??? Mail'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.green,
        ));
        return Navigator.push(context, MaterialPageRoute(builder: (context) => Login(),));
      } else {
        return ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('L???i y??u c???u.'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.green,
        ));
      }
    } catch (err) {
      print(err);
    }

    // print(await http.read(Uri.parse('https://example.com/foobar.txt')));
  }
}
