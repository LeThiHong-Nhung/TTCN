import 'package:ejm/share/share.dart';
import 'package:ejm/views/has_gone/tour_is_not_rate.dart';
import 'package:ejm/views/has_gone/tour_rated.dart';
import 'package:flutter/material.dart';

class HasGone extends StatefulWidget {
  const HasGone({Key key}) : super(key: key);

  @override
  _HasGoneState createState() => _HasGoneState();
}

class _HasGoneState extends State<HasGone> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: GreenColor.withOpacity(0),
        leading: IconButton(
          onPressed: () => Navigator.pop(context),
          icon: Icon(
            Icons.arrow_left,
            color: GreenColor,
            size: 25,
          ),
        ),
        title: Container(
          width: MediaQuery.of(context).size.width * 0.65,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Text(
                'Tour đã đi',
                style: TextStyle(color: GreenColor),
              ),
            ],
          ),
        ),
        elevation: 0,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(10.0),
          child: Column(
            children: [
              TourIsNotRate(),
              SizedBox(
                height: 50,
              ),
              TourRated(),
            ],
          ),
        ),
      ),
    );
  }
}
