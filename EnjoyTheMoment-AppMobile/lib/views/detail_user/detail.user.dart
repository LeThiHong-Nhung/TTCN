import 'package:ejm/share/share.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/has_gone/tour_has_gone.dart';
import 'package:ejm/views/user_behavior/change_pass.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';

class DetailUser extends StatelessWidget {
  const DetailUser({Key key}) : super(key: key);

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
            Text(USERNAME != null ? USERNAME : 'NGƯỜI DÙNG'),
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
      body: Container(
        child: Column(
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
            Padding(
              padding: const EdgeInsets.only(top: 30, bottom: 10),
              child: Text(
                'Email',
                style: TextStyle(
                    fontSize: 30,
                    fontWeight: FontWeight.w800,
                    color: GreenColorAccent),
              ),
            ),
            Container(
              padding: EdgeInsets.fromLTRB(30, 0, 30, 0),
              decoration: BoxDecoration(),
              child: Text(
                EMAIL != null ? EMAIL : 'NGƯỜI DÙNG',
                style: TextStyle(fontSize: 20, fontWeight: FontWeight.w500),
              ),
            ),
            Spacer(),
            //button list tour has gone
            Container(
              child: TextButton(
                  onPressed: () => Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => HasGone(),
                      )),
                  child: Container(
                    padding: EdgeInsets.fromLTRB(100, 10, 100, 10),
                    decoration: BoxDecoration(
                        color: BlueColor,
                        borderRadius: BorderRadius.all(Radius.circular(50))),
                    child: Text(
                      'Tour đã đi',
                      style: TextStyle(fontSize: 20, color: Colors.white),
                    ),
                  )),
            ),
            Container(
              child: TextButton(
                  onPressed: () => Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => ChangePass(),
                      )),
                  child: Container(
                    padding: EdgeInsets.fromLTRB(100, 10, 100, 10),
                    decoration: BoxDecoration(
                        color: GreenColor,
                        borderRadius: BorderRadius.all(Radius.circular(50))),
                    child: Text(
                      'Đổi mật khẩu',
                      style: TextStyle(fontSize: 20, color: Colors.white),
                    ),
                  )),
            ),
            Container(
              child: TextButton(
                  onPressed: () {
                    USERNAME = null;
                    EMAIL = null;
                    Navigator.pop(context);
                  },
                  child: Container(
                    padding: EdgeInsets.fromLTRB(100, 10, 100, 10),
                    decoration: BoxDecoration(
                        color: Colors.redAccent,
                        borderRadius: BorderRadius.all(Radius.circular(50))),
                    child: Text(
                      'Đăng xuất',
                      style: TextStyle(fontSize: 20, color: Colors.white),
                    ),
                  )),
            ),
            SizedBox(
              height: 100,
            )
          ],
        ),
      ),
    );
  }
}
