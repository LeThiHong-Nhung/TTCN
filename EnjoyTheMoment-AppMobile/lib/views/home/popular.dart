import 'package:ejm/model/tours.dart';
import 'package:ejm/network/network_tour.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class PopularTour extends StatefulWidget {
  const PopularTour({Key key}) : super(key: key);

  @override
  _PopularTourState createState() => _PopularTourState();
}

class _PopularTourState extends State<PopularTour> {
  List<Tour> _popularTour = List<Tour>();

  @override
  void initState() {
    super.initState();
    fetchTourPopular().then((dataFromServer) {
      setState(() {
        _popularTour = dataFromServer;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 540,
      child: ListView.builder(
          itemCount: _popularTour.length,
          physics: const NeverScrollableScrollPhysics(),
          itemBuilder: (context, index) {
            return Container(
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
                      builder: (context) =>
                          DetailTour(tour: _popularTour[index]),
                    )),
                child: Row(
                  children: [
                    ClipRRect(
                      borderRadius: BorderRadius.only(
                          topLeft: Radius.circular(20),
                          bottomLeft: Radius.circular(20)),
                      child: Image.network(
                        _popularTour[index].hinhanh != ''
                            ? IMG_DIR + _popularTour[index].hinhanh
                            :
                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
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
                              _popularTour[index].tentour,
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
                              _popularTour[index].mota,
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
                                .format(int.parse(_popularTour[index].giatour)),
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
                              double.parse(_popularTour[index].danhgia)
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
          }),
    );
  }
}
