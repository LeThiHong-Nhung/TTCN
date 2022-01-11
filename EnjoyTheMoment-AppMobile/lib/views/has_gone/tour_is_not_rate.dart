import 'dart:convert';

import 'package:ejm/model/ticket.dart';
import 'package:ejm/network/network_ticket.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/has_gone/tour_has_gone.dart';
import 'package:ejm/views/home/home.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;

class TourIsNotRate extends StatefulWidget {
  const TourIsNotRate({Key key}) : super(key: key);

  @override
  _TourIsNotRateState createState() => _TourIsNotRateState();
}

class _TourIsNotRateState extends State<TourIsNotRate> {
  List<Ticket> _tickets = List<Ticket>();

  @override
  void initState() {
    super.initState();
    if (EMAIL != null) {
      fetchTicket(notRatedTour + EMAIL).then((dataFromServer) {
        setState(() {
          _tickets = dataFromServer;
        });
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 160.0 * _tickets.length +
          10 * (_tickets.length == 0 ? 0 : _tickets.length - 1),
      child: ListView.builder(
        itemCount: _tickets.length,
        itemBuilder: (context, index) {
          return StateTicket(
            ticket: _tickets[index],
          );
        },
      ),
    );
  }
}

class StateTicket extends StatefulWidget {
  final Ticket ticket;
  const StateTicket({Key key, this.ticket}) : super(key: key);

  @override
  _StateTicketState createState() => _StateTicketState();
}

class _StateTicketState extends State<StateTicket> {
  double _rating = 5.0;
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
      child: Column(
        children: [
          Container(
            height: 100,
            margin: EdgeInsets.only(bottom: 10),
            decoration: BoxDecoration(
                color: Color.fromRGBO(38, 38, 38, 0.05),
                borderRadius: BorderRadius.only(
                    topLeft: Radius.circular(20),
                    topRight: Radius.circular(20))),
            child: MaterialButton(
              padding: EdgeInsets.all(0),
              onPressed: () => Navigator.push(
                  context,
                  MaterialPageRoute(
                      // builder: (context) => DetailTour('T1'),
                      )),
              child: Row(
                children: [
                  ClipRRect(
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(20),
                    ),
                    child: Image.network(
                      widget.ticket.hinhanh != ''
                          ? IMG_DIR + widget.ticket.hinhanh
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
                          width: 250,
                          child: Text(
                            widget.ticket.tentour,
                            style: TextStyle(
                                fontSize: 20,
                                fontWeight: FontWeight.bold,
                                color: BlackText),
                          ),
                        ),
                        Spacer(),
                        Text(
                          NumberFormat.currency(locale: 'vi', symbol: 'VND')
                              .format(int.parse(widget.ticket.giatour)),
                          style: TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                              color: BlackText),
                        ),
                      ],
                    ),
                  ),
                  Spacer(),
                ],
              ),
            ),
          ),
          Container(
            width: MediaQuery.of(context).size.width,
            decoration: BoxDecoration(
                color: Color.fromRGBO(38, 38, 38, 0.05),
                borderRadius: BorderRadius.only(
                    bottomRight: Radius.circular(20),
                    bottomLeft: Radius.circular(20))),
            child: Row(
              children: [
                Spacer(),
                RatingBar.builder(
                  initialRating: 5,
                  minRating: 1,
                  direction: Axis.horizontal,
                  allowHalfRating: true,
                  itemCount: 5,
                  itemPadding: EdgeInsets.symmetric(horizontal: 4.0),
                  itemBuilder: (context, _) => Icon(
                    Icons.star,
                    color: Colors.amber,
                  ),
                  onRatingUpdate: (rating) {
                    print(rating);
                    setState(() {
                      _rating = rating;
                    });
                  },
                ),
                TextButton(
                    onPressed: () {
                      sendRating();
                      Navigator.pop(context);
                      return Navigator.push(context, MaterialPageRoute(builder: (context) => HasGone()));
                    },
                    child: Text(
                      'Gửi',
                      style: TextStyle(fontSize: 20, color: GreenColor),
                    )),
                Spacer(),
              ],
            ),
          )
        ],
      ),
    );
  }

  Future sendRating() async {
    try {
      var response = await http.post(
          Uri.parse('https://quanlitourejm.000webhostapp.com/api/hasgone/rate.php'),
          body: {"sove": widget.ticket.sove, "rating": _rating.toString()});

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        if (data['message'] == 'success') {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
            content: Row(
              children: [
                Spacer(),
                Text('Đánh giá thành công.'),
                Spacer(),
              ],
            ),
            backgroundColor: Colors.green,
          ));
        }
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Row(
            children: [
              Spacer(),
              Text('Lỗi yêu cầu hệ thống.'),
              Spacer(),
            ],
          ),
          backgroundColor: Colors.red,
        ));
      }
    } catch (err) {
      print(err);
    }
  }
}
