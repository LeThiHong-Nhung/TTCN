import 'dart:convert';

import 'package:ejm/model/tours.dart';
import 'package:ejm/model/vehicle.dart';
import 'package:ejm/network/network_vehicle.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/checkout/checkout.dart';
import 'package:ejm/views/home/places.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;

class DetailTour extends StatefulWidget {
  final Tour tour;
  const DetailTour({Key key, this.tour}) : super(key: key);
  @override
  _DetailTourState createState() => _DetailTourState();
}

class _DetailTourState extends State<DetailTour> {
  bool _favorite = false;
  List<Vehicle> vehicles = List<Vehicle>();

  @override
  void initState() {
    super.initState();
    setState(() {
      fetchVehicle(widget.tour.matour).then((value) {
        vehicles = value;
      });
      if (EMAIL != null)
        getFavorite();
      else
        _favorite = false;
    });
  }

  void getFavorite() async {
    final response = await http.get(Uri.parse(
        'https://quanlitourejm.000webhostapp.com/api/favorite/get.php?username=' +
            EMAIL +
            '&matour=' +
            widget.tour.matour));
    if (response.statusCode == 200) {
      var result = json.decode(response.body);
      setState(() {
        _favorite = result['result'] as bool;
      });
    } else {
      throw Exception("Request API Error");
    }
  }

  void postFavorite() async {
    final response = await http.post(
        Uri.parse('https://quanlitourejm.000webhostapp.com/api/favorite/post.php'),
        body: {'username': EMAIL, 'matour': widget.tour.matour});
    if (response.statusCode == 200) {
      var result = json.decode(response.body);
      print(result);
      if (result['result'] == 'insert') {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('Đã thêm vào danh sách yêu thích'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.greenAccent,
        ));
      }
      if (result['result'] == 'delete') {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('Đã xóa khỏi danh sách yêu thích'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.redAccent,
        ));
      }
    } else {
      throw Exception("Request API Error");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              height: 500,
              child: Stack(
                children: [
                  Image.network(
                    widget.tour.hinhanh != ''
                        ? IMG_DIR + widget.tour.hinhanh
                        : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                    height: 500,
                    width: MediaQuery.of(context).size.width,
                    fit: BoxFit.cover,
                  ),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      SizedBox(
                        height: 45,
                      ),
                      Row(
                        children: [
                          IconButton(
                              onPressed: () => Navigator.pop(context),
                              icon: Icon(
                                Icons.arrow_back,
                                color: Colors.white,
                                size: 30,
                              )),
                          Spacer(),
                          IconButton(
                              onPressed: () {
                                if (EMAIL != null) {
                                  setState(() {
                                    _favorite = !_favorite;
                                  });
                                  postFavorite();
                                } else {
                                  Navigator.push(
                                      context,
                                      MaterialPageRoute(
                                          builder: (context) => Login()));
                                }
                              },
                              icon: Icon(
                                Icons.favorite,
                                color: _favorite ? Colors.red : Colors.white,
                                size: 35,
                              )),
                          SizedBox(
                            width: 10,
                          )
                        ],
                      ),
                      Spacer(),
                      Padding(
                        padding: const EdgeInsets.only(left: 25, bottom: 7),
                        child: Text(
                          widget.tour.tentour,
                          style: TextStyle(
                              fontSize: 30,
                              fontWeight: FontWeight.w700,
                              color: Colors.white),
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(left: 25, bottom: 7),
                        child: Text(
                          DateFormat('dd/MM/yyyy')
                                  .format(DateTime.parse(widget.tour.ngaybd)) +
                              " - " +
                              DateFormat('dd/MM/yyyy')
                                  .format(DateTime.parse(widget.tour.ngaykt)),
                          style: TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.w500,
                              color: Colors.white),
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(left: 25, bottom: 10),
                        child: Row(
                          children: [
                            RatingBar.builder(
                              initialRating: double.parse(widget.tour.danhgia),
                              minRating: 1,
                              direction: Axis.horizontal,
                              allowHalfRating: true,
                              itemCount: 5,
                              itemPadding:
                                  EdgeInsets.symmetric(horizontal: 0.0),
                              itemBuilder: (context, _) => Icon(
                                Icons.star,
                                color: Colors.white,
                              ),
                            ),
                            Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Text(
                                double.parse(widget.tour.danhgia)
                                    .toString(),
                                style: TextStyle(
                                    fontSize: 30,
                                    fontWeight: FontWeight.w500,
                                    color: Colors.white),
                              ),
                            ),
                          ],
                        ),
                      ),
                      Container(
                        height: 140,
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.only(
                              topLeft: Radius.circular(50),
                              topRight: Radius.circular(50)),
                          color: Colors.white,
                          boxShadow: [
                            BoxShadow(
                              color: BlackText.withOpacity(0.3),
                              spreadRadius: 0,
                              blurRadius: 5,
                              offset:
                                  Offset(0, -6), // changes position of shadow
                            ),
                          ],
                        ),
                        padding: EdgeInsets.all(20),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Column(
                                children: [
                                  Container(
                                    decoration: BoxDecoration(
                                      borderRadius:
                                          BorderRadius.all(Radius.circular(50)),
                                      color: Color.fromRGBO(38, 38, 38, 0.05),
                                    ),
                                    child: Padding(
                                      padding: const EdgeInsets.only(
                                          top: 16,
                                          bottom: 16,
                                          left: 23,
                                          right: 23),
                                      child: Text(
                                        '\$',
                                        style: TextStyle(
                                            fontSize: 25,
                                            fontWeight: FontWeight.w700,
                                            color: BlueColor),
                                      ),
                                    ),
                                  ),
                                  SizedBox(
                                    height: 5,
                                  ),
                                  Text(
                                    NumberFormat.currency(
                                            locale: 'vi', symbol: '')
                                        .format(int.parse(widget.tour.giatour)),
                                    style: TextStyle(
                                        fontWeight: FontWeight.w500,
                                        color: Colors.blueAccent),
                                  )
                                ],
                              ),
                            ),
                            Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Column(
                                children: [
                                  Container(
                                    decoration: BoxDecoration(
                                      borderRadius:
                                          BorderRadius.all(Radius.circular(50)),
                                      color: Color.fromRGBO(38, 38, 38, 0.05),
                                    ),
                                    child: Padding(
                                      padding: const EdgeInsets.all(7.0),
                                      child: IconButton(
                                          onPressed: () => showDialog<String>(
                                                context: context,
                                                builder:
                                                    (BuildContext context) =>
                                                        AlertDialog(
                                                  title: Text(
                                                      'Danh sánh phương tiện'),
                                                  content: Container(
                                                    height:
                                                        MediaQuery.of(context)
                                                                .size
                                                                .height *
                                                            0.4,
                                                    width:
                                                        MediaQuery.of(context)
                                                                .size
                                                                .width *
                                                            0.4,
                                                    decoration: BoxDecoration(
                                                      borderRadius:
                                                          BorderRadius.all(
                                                              Radius.circular(
                                                                  40)),
                                                    ),
                                                    child: Container(
                                                      child: ListView.builder(
                                                        itemCount:
                                                            vehicles.length,
                                                        itemBuilder:
                                                            (context, index) {
                                                          return Card(
                                                            child: Center(
                                                                child: Padding(
                                                              padding:
                                                                  const EdgeInsets
                                                                          .all(
                                                                      10.0),
                                                              child: Text(
                                                                vehicles[index]
                                                                    .tenphuongtien,
                                                                style: TextStyle(
                                                                    fontSize:
                                                                        20),
                                                              ),
                                                            )),
                                                          );
                                                        },
                                                      ),
                                                    ),
                                                  ),
                                                  actions: [
                                                    TextButton(
                                                      onPressed: () =>
                                                          Navigator.pop(
                                                              context, 'Hủy'),
                                                      child: const Text('Hủy'),
                                                    ),
                                                  ],
                                                ),
                                              ),
                                          icon: Icon(
                                            Icons.directions_car,
                                            color: BlueColor,
                                            size: 30,
                                          )),
                                    ),
                                  ),
                                  SizedBox(
                                    height: 5,
                                  ),
                                  Text(
                                    vehicles.length.toString() + " phương tiện",
                                    style: TextStyle(
                                        fontWeight: FontWeight.w500,
                                        color: BlueColor),
                                  )
                                ],
                              ),
                            ),
                            Padding(
                              padding: const EdgeInsets.all(8.0),
                              child: Column(
                                children: [
                                  Container(
                                    decoration: BoxDecoration(
                                      borderRadius:
                                          BorderRadius.all(Radius.circular(50)),
                                      color: Color.fromRGBO(38, 38, 38, 0.05),
                                    ),
                                    child: Padding(
                                      padding: const EdgeInsets.all(16.0),
                                      child: Icon(
                                        Icons.hotel,
                                        color: BlueColor,
                                        size: 30,
                                      ),
                                    ),
                                  ),
                                  SizedBox(
                                    height: 5,
                                  ),
                                  Row(
                                    children: [
                                      Text(
                                        widget.tour.khachsan,
                                        style: TextStyle(
                                            fontWeight: FontWeight.w500,
                                            color: BlueColor),
                                      ),
                                      Icon(Icons.star,
                                          size: 17, color: BlueColor)
                                    ],
                                  )
                                ],
                              ),
                            ),
                          ],
                        ),
                      )
                    ],
                  )
                ],
              ),
            ),
            //discription
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Spacer(),
                Container(
                  padding: EdgeInsets.only(left: 68, right: 68),
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.all(Radius.circular(50)),
                    color: GreenColor,
                  ),
                  child: Text(
                    'Mô tả',
                    style: TextStyle(
                        fontSize: 30,
                        fontWeight: FontWeight.bold,
                        color: Colors.white),
                  ),
                ),
                Spacer(),
              ],
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(30, 20, 30, 10),
              child: Text(
                widget.tour.mota,
                style: TextStyle(fontSize: 18),
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(20, 20, 20, 10),
              child: Places(
                matour: widget.tour.matour,
              ),
            ),
            //button to check out
            Row(
              children: [
                Spacer(),
                TextButton(
                    onPressed: () {
                      if (EMAIL == null) {
                        return Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => Login(),
                            ));
                      } else {
                        return Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => Checkout(
                                tour: widget.tour,
                              ),
                            ));
                      }
                    },
                    child: Container(
                      decoration: BoxDecoration(
                          color: BlueColor,
                          borderRadius: BorderRadius.all(Radius.circular(10))),
                      child: Padding(
                        padding: const EdgeInsets.fromLTRB(40, 10, 40, 10),
                        child: Text(
                          'Đặt',
                          style: TextStyle(fontSize: 30, color: Colors.white),
                        ),
                      ),
                    )),
                Spacer(),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
