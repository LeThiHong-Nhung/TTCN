import 'package:ejm/model/tours.dart';
import 'package:ejm/network/network_tour.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:ejm/views/home/popular.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';
import 'package:flutter_slidable/flutter_slidable.dart';
import 'package:intl/intl.dart';

class Favorite extends StatefulWidget {
  const Favorite({Key key}) : super(key: key);

  @override
  _FavoriteState createState() => _FavoriteState();
}

class _FavoriteState extends State<Favorite> {
  List<Tour> _favoriteTour = List<Tour>();

  @override
  void initState() {
    super.initState();
    fetchTourUrl(favoriteTour + EMAIL).then((dataFromServer) {
      setState(() {
        _favoriteTour = dataFromServer;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: GreenColor,
        leading: Icon(
          Icons.arrow_back,
          color: GreenColor,
        ),
        title: Center(
          child: Text(
            'Yêu thích',
            style: TextStyle(
                fontSize: 25,
                fontWeight: FontWeight.w800,
                fontStyle: FontStyle.italic),
          ),
        ),
        actions: [
          Icon(
            Icons.arrow_back,
            color: GreenColor,
            size: 50,
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Container(
          height: MediaQuery.of(context).size.height,
          child: ListView.builder(
            itemCount: _favoriteTour.length,
            itemBuilder: (context, index) {
              return Container(
                height: 100,
                margin: EdgeInsets.only(bottom: 10),
                decoration: BoxDecoration(
                    color: Color.fromRGBO(38, 38, 38, 0.05),
                    borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(10),
                        bottomLeft: Radius.circular(10))),
                child: MaterialButton(
                  padding: EdgeInsets.all(0),
                  onPressed: () => Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => DetailTour(tour: _favoriteTour[index]),
                      )),
                  child: Row(
                    children: [
                      ClipRRect(
                        borderRadius: BorderRadius.only(
                            topLeft: Radius.circular(10),
                            bottomLeft: Radius.circular(10)),
                        child: Image.network(
                          _favoriteTour[index].hinhanh != ''
                              ? IMG_DIR + _favoriteTour[index].hinhanh
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
                                _favoriteTour[index].tentour,
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
                                _favoriteTour[index].mota,
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
                              NumberFormat.currency(locale: 'vi', symbol: 'VND')
                                  .format(int.parse(_favoriteTour[index].giatour)),
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
                                double.parse(_favoriteTour[index].danhgia)
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
              );
            },
          ),
        ),
      ),
    );
  }
}
