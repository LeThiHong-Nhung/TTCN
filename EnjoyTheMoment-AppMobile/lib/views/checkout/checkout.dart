import 'dart:convert';

import 'package:ejm/share/url_api.dart';
import 'package:ejm/views/home/home.dart';
import 'package:http/http.dart' as http;

import 'package:ejm/model/tours.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class Checkout extends StatefulWidget {
  final Tour tour;
  const Checkout({Key key, this.tour}) : super(key: key);

  @override
  _CheckoutState createState() => _CheckoutState();
}

class _CheckoutState extends State<Checkout> {
  int perNum = 1;
  int _total = 0;

  final checkoutKey = GlobalKey<FormState>();
  String gender = 'Nam';
  var emailController = TextEditingController();
  var cmndController = TextEditingController();
  var nameController = TextEditingController();
  var sdtController = TextEditingController();
  var addressController = TextEditingController();

  @override
  void initState() {
    super.initState();
    setState(() {
      _total = int.parse(widget.tour.giatour);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        elevation: 0,
        backgroundColor: GreenColor,
      ),
      body: SingleChildScrollView(
          child: Form(
        key: checkoutKey,
        child: Column(
          children: [
            Stack(
              children: [
                Container(
                  height: MediaQuery.of(context).size.height * 0.12,
                  width: MediaQuery.of(context).size.width,
                  decoration: BoxDecoration(
                    color: GreenColor,
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Spacer(),
                      // IconButton(
                      //     onPressed: () => Navigator.pop(context),
                      //     icon: Icon(
                      //       Icons.arrow_back,
                      //       color: Colors.white,
                      //     )),
                      Row(
                        children: [
                          Spacer(),
                          Text(
                            'H??A ????N',
                            style: TextStyle(
                                fontSize: 40,
                                fontStyle: FontStyle.italic,
                                fontWeight: FontWeight.w900,
                                color: Colors.white),
                          ),
                          Spacer(),
                        ],
                      ),
                      SizedBox(
                        height: 10,
                      ),
                      Container(
                        height: 25,
                        width: MediaQuery.of(context).size.width,
                        decoration: BoxDecoration(
                            borderRadius: BorderRadius.only(
                              topLeft: Radius.circular(50),
                              topRight: Radius.circular(50),
                            ),
                            color: Colors.white,
                            boxShadow: [
                              BoxShadow(
                                  color: Colors.white.withOpacity(0.2),
                                  blurRadius: 10,
                                  offset: Offset(0, -6))
                            ]),
                      )
                    ],
                  ),
                ),
              ],
            ),
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Container(
                    height: 100,
                    margin: EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                        color: Color.fromRGBO(38, 38, 38, 0.05),
                        borderRadius: BorderRadius.only(
                            topLeft: Radius.circular(20),
                            bottomLeft: Radius.circular(20))),
                    child: MaterialButton(
                      padding: EdgeInsets.all(0),
                      onPressed: () => Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => DetailTour(tour: widget.tour),
                          )),
                      child: Row(
                        children: [
                          ClipRRect(
                            borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(20),
                                bottomLeft: Radius.circular(20)),
                            child: Image.network(
                              widget.tour.hinhanh != ''
                                  ? IMG_DIR + widget.tour.hinhanh
                                  : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                              height: 100,
                              width: 110,
                              fit: BoxFit.cover,
                            ),
                          ),
                          Padding(
                            padding: const EdgeInsets.all(8.0),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Container(
                                  width: 200,
                                  child: Text(
                                    widget.tour.tentour,
                                    maxLines: 1,
                                    overflow: TextOverflow.ellipsis,
                                    softWrap: false,
                                    style: TextStyle(
                                        fontSize: 18,
                                        fontWeight: FontWeight.bold,
                                        color: BlackText),
                                  ),
                                ),
                                Spacer(),
                                Container(
                                  width: 200,
                                  child: Text(
                                    widget.tour.mota,
                                    maxLines: 1,
                                    overflow: TextOverflow.ellipsis,
                                    softWrap: false,
                                    style: TextStyle(
                                        fontSize: 12,
                                        fontWeight: FontWeight.w400,
                                        color: BlackText),
                                  ),
                                ),
                                Spacer(),
                                Text(
                                  NumberFormat.currency(
                                          locale: 'vi', symbol: 'VND')
                                      .format(int.parse(widget.tour.giatour)),
                                  style: TextStyle(
                                      fontSize: 15,
                                      fontWeight: FontWeight.bold,
                                      color: BlackText),
                                ),
                              ],
                            ),
                          ),
                          Spacer(),
                          Container(
                            height: 100,
                            decoration: BoxDecoration(
                                borderRadius: BorderRadius.circular(8),
                                color: GreenColor),
                            child: Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Text(
                                    double.parse(widget.tour.danhgia)
                                        .toString(),
                                    style: TextStyle(
                                        fontWeight: FontWeight.w700,
                                        color: Colors.white,
                                        fontSize: 17),
                                  ),
                                  Icon(
                                    Icons.star,
                                    color: Colors.white,
                                    size: 17,
                                  )
                                ],
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 8,
                  ),
                  //Information of day
                  Row(
                    children: [
                      Text(
                        'Ng??y b???t ?????u: ' +
                            DateFormat('dd/MM/yyyy')
                                .format(DateTime.parse(widget.tour.ngaybd)),
                        style: TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.w500,
                            color: Colors.black54),
                      ),
                      Spacer(),
                      Text(
                        'Ng??y k???t th??c: ' +
                            DateFormat('dd/MM/yyyy')
                                .format(DateTime.parse(widget.tour.ngaykt)),
                        style: TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.w500,
                            color: Colors.black54),
                      ),
                    ],
                  ),
                  //card show total money to book
                  SizedBox(
                    height: 40,
                  ),
                  Row(
                    children: [
                      Spacer(),
                      Text(
                        '?????t cho',
                        style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.w900,
                            color: GreenColor.withOpacity(0.7)),
                      ),
                      Spacer(),
                      TextButton(
                          onPressed: () {
                            setState(() {
                              perNum == 1 ? perNum : perNum--;
                              _total = int.parse(widget.tour.giatour) * perNum;
                            });
                          },
                          child: Container(
                            width: 50,
                            height: 40,
                            padding: EdgeInsets.fromLTRB(17, 0, 20, 0),
                            decoration: BoxDecoration(
                                borderRadius:
                                    BorderRadius.all(Radius.circular(10)),
                                color: GreenColor.withOpacity(0.7)),
                            child: Text(
                              '-',
                              style: TextStyle(
                                  fontSize: 30,
                                  fontWeight: FontWeight.w900,
                                  color: Colors.white),
                            ),
                          )),
                      Padding(
                        padding: const EdgeInsets.fromLTRB(10, 0, 10, 0),
                        child: Text(
                          perNum.toString(),
                          style: TextStyle(fontSize: 30),
                        ),
                      ),
                      TextButton(
                          onPressed: () {
                            setState(() {
                              perNum == 9 ? perNum : perNum++;
                              _total = int.parse(widget.tour.giatour) * perNum;
                            });
                          },
                          child: Container(
                            width: 50,
                            height: 40,
                            padding: EdgeInsets.fromLTRB(17, 0, 20, 0),
                            decoration: BoxDecoration(
                                borderRadius:
                                    BorderRadius.all(Radius.circular(10)),
                                color: GreenColor.withOpacity(0.7)),
                            child: Text(
                              '+',
                              style: TextStyle(
                                  fontSize: 30,
                                  fontWeight: FontWeight.w900,
                                  color: Colors.white),
                            ),
                          )),
                      Spacer(),
                      Text(
                        'ng?????i',
                        style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.w900,
                            color: GreenColor.withOpacity(0.7)),
                      ),
                      Spacer(),
                    ],
                  ),
                  //Information of user to push -> create order
                  SizedBox(
                    height: 40,
                  ),
                  Container(
                    height: 2,
                    width: MediaQuery.of(context).size.width,
                    decoration:
                        BoxDecoration(color: Colors.black.withOpacity(0.6)),
                  ),
                  Row(
                    children: [
                      Padding(
                        padding: const EdgeInsets.only(bottom: 20, top: 20),
                        child: Text(
                          'Gi?? tour',
                          style: TextStyle(
                              fontSize: 30,
                              fontWeight: FontWeight.bold,
                              color: BlackText),
                        ),
                      ),
                      Spacer()
                    ],
                  ),
                  Container(
                    width: MediaQuery.of(context).size.width,
                    decoration: BoxDecoration(
                        border: Border.all(color: BlackText.withOpacity(0.9)),
                        borderRadius: BorderRadius.all(Radius.circular(20))),
                    child: Padding(
                      padding: const EdgeInsets.all(15.0),
                      child: Column(
                        children: [
                          Row(
                            children: [
                              Text(
                                'Gi?? v??: ',
                                style: TextStyle(fontSize: 18),
                              ),
                              Text(
                                NumberFormat.currency(
                                        locale: 'vi', symbol: 'VND')
                                    .format(int.parse(widget.tour.giatour)),
                                style: TextStyle(
                                    fontSize: 18, fontWeight: FontWeight.w600),
                              ),
                              Spacer(),
                              Text(
                                perNum.toString(),
                                style: TextStyle(
                                    fontSize: 18, fontWeight: FontWeight.w900),
                              ),
                              Text(
                                ' ng?????i',
                                style: TextStyle(
                                    fontSize: 13, fontWeight: FontWeight.w500),
                              )
                            ],
                          ),
                          SizedBox(
                            height: 10,
                          ),
                          Container(
                            height: 1,
                            width: MediaQuery.of(context).size.width,
                            decoration: BoxDecoration(
                                color: Colors.black.withOpacity(0.6)),
                          ),
                          SizedBox(
                            height: 10,
                          ),
                          Row(
                            children: [
                              Spacer(),
                              Text(
                                'T???ng chi ph??: ',
                                style:
                                    TextStyle(fontSize: 20, color: GreenColor),
                              ),
                              Text(
                                NumberFormat.currency(
                                        locale: 'vi', symbol: 'VND')
                                    .format(_total),
                                style: TextStyle(
                                    fontSize: 22, fontWeight: FontWeight.w800),
                              ),
                              Spacer(),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 40,
                  ),
                  Row(
                    children: [
                      Spacer(),
                      Container(
                        padding: EdgeInsets.fromLTRB(50, 5, 50, 5),
                        decoration: BoxDecoration(
                            border: Border.all(
                                color: GreenColor.withOpacity(0.9), width: 3),
                            borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(20),
                                topRight: Radius.circular(20))),
                        child: Text(
                          'Th??ng tin',
                          style: TextStyle(
                              fontSize: 25,
                              fontWeight: FontWeight.w600,
                              color: GreenColor),
                        ),
                      ),
                      Spacer(),
                    ],
                  ),
                  Card(
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.all(Radius.circular(20))),
                    color: GreenColor.withOpacity(0.6),
                    shadowColor: GreenColor,
                    child: Padding(
                      padding: const EdgeInsets.all(20.0),
                      child: Container(
                        width: MediaQuery.of(context).size.width,
                        child: Column(
                          children: [
                            TextFormField(
                              controller: nameController,
                              decoration: InputDecoration(
                                hintText: 'H??? v?? t??n',
                                hintStyle: TextStyle(color: Colors.white),
                              ),
                              validator: (value) {
                                return isValid(value, patternName)
                                    ? null
                                    : "Nh???p v??o ????ng H??? v?? T??n";
                              },
                              style:
                                  TextStyle(color: Colors.white, fontSize: 20),
                            ),
                            Row(
                              children: [
                                Text(
                                  'Gi???i t??nh',
                                  style: TextStyle(
                                      color: Colors.white, fontSize: 20),
                                ),
                                Spacer(),
                                Theme(
                                  data: Theme.of(context).copyWith(
                                    canvasColor: Colors.green,
                                  ),
                                  child: DropdownButton<String>(
                                    value: gender,
                                    style: TextStyle(
                                        color: Colors.white, fontSize: 20),
                                    items: <String>['Nam', 'N???', 'Kh??c']
                                        .map((String value) {
                                      return DropdownMenuItem<String>(
                                        value: value,
                                        child: Text(value),
                                      );
                                    }).toList(),
                                    onChanged: (value) {
                                      setState(() {
                                        gender = value;
                                      });
                                    },
                                  ),
                                ),
                                SizedBox(width: 10),
                              ],
                            ),
                            Container(
                              height: 1,
                              color: Colors.black54,
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            TextFormField(
                              controller: cmndController,
                              decoration: InputDecoration(
                                hintText: 'S??? CMND',
                                hintStyle: TextStyle(color: Colors.white),
                              ),
                              validator: (value) {
                                return isValid(value, patternCMND)
                                    ? null
                                    : "Nh???p v??o ????ng CMND";
                              },
                              style:
                                  TextStyle(color: Colors.white, fontSize: 20),
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            TextFormField(
                              controller: emailController,
                              decoration: InputDecoration(
                                hintText: 'Email',
                                hintStyle: TextStyle(color: Colors.white),
                              ),
                              validator: (value) {
                                return isValid(value, patternEmail)
                                    ? null
                                    : "Nh???p v??o ????ng ?????a ch??? email";
                              },
                              style:
                                  TextStyle(color: Colors.white, fontSize: 20),
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            TextFormField(
                              controller: sdtController,
                              decoration: InputDecoration(
                                hintText: 'S??? ??i???n tho???i',
                                hintStyle: TextStyle(color: Colors.white),
                              ),
                              validator: (value) {
                                return isValid(value, patternPhone)
                                    ? null
                                    : "Nh???p v??o ????ng s??? ??i???n tho???i.";
                              },
                              style:
                                  TextStyle(color: Colors.white, fontSize: 20),
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            TextFormField(
                              controller: addressController,
                              decoration: InputDecoration(
                                hintText: '?????a ch???',
                                hintStyle: TextStyle(color: Colors.white),
                              ),
                              validator: (value) {
                                return isValid(value, patternAddress)
                                    ? null
                                    : "Nh???p v??o ????ng ?????a ch???";
                              },
                              style:
                                  TextStyle(color: Colors.white, fontSize: 20),
                            )
                          ],
                        ),
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 20,
                  ),
                  TextButton(
                      onPressed: () {
                        if (checkoutKey.currentState.validate()) {
                          showDialog<String>(
                            context: context,
                            builder: (context) => AlertDialog(
                              title: Center(child: Text('X??c nh???n ?????t Tour')),
                              content: Card(
                                elevation: 0.0,
                                child: Text(
                                  'B???n x??c nh???n ?????t ' + widget.tour.tentour,
                                  style: TextStyle(
                                      color: Colors.black54, fontSize: 25),
                                ),
                              ),
                              actions: [
                                Row(
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceBetween,
                                  children: [
                                    Spacer(),
                                    TextButton(
                                      child: Text(
                                        'X??c nh???n',
                                        style: TextStyle(
                                            fontSize: 20, color: Colors.red),
                                      ),
                                      onPressed: () {
                                        // print(nameController.text);
                                        // print(gender);
                                        // print(cmndController.text);
                                        // print(emailController.text);
                                        // print(sdtController.text);
                                        // print(addressController.text);
                                        // print(widget.tour.matour);
                                        // print(EMAIL);
                                        // print(perNum.toString());
                                        checkout();
                                      },
                                    ),
                                    TextButton(
                                      child: Text('H???y',
                                          style: TextStyle(fontSize: 20)),
                                      onPressed: () => Navigator.pop(context),
                                    ),
                                    Spacer(),
                                  ],
                                )
                              ],
                            ),
                          );
                        }
                      },
                      child: Container(
                          padding: EdgeInsets.fromLTRB(30, 10, 30, 10),
                          decoration: BoxDecoration(
                              color: Colors.lightBlue,
                              borderRadius:
                                  BorderRadius.all(Radius.circular(20))),
                          child: Text(
                            '?????t ngay',
                            style: TextStyle(fontSize: 20, color: Colors.white),
                          )))
                ],
              ),
            )
          ],
        ),
      )),
    );
  }

  Future checkout() async {
    try {
      final response = await http.post(Uri.parse(checkoutAPI), body: {
        'matour': widget.tour.matour,
        'username': EMAIL,
        'quantity': perNum.toString(),
        'name': nameController.text,
        'gender': gender,
        'cmnd': cmndController.text,
        'email': emailController.text,
        'phone': sdtController.text,
        'address': addressController.text,
      });

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        print(data);

        if (data['message'] == 'successful') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('?????t v?? th??nh c??ng.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.green,
          ));
          Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => MyHomePage(),
              ));
        }
        if (data['message'] == 'error insert') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('L???i t???o v??.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.redAccent,
          ));
        }
        if (data['message'] == 'error information') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Ch???ng minh nh??n d??n ???? ???????c s??? d???ng.\n'
                    'D??? li???u kh??ng kh???p v???i ch???ng minh nh??n d??n!.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.redAccent,
          ));
        }
      } else {
        throw Exception("Request API Error");
        // print('123');
      }
    } catch(err) {
      print(err);
    }
  }
}
