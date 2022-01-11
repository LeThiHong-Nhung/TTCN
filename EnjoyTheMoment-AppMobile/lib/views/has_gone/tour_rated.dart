import 'package:ejm/model/tours.dart';
import 'package:ejm/network/network_tour.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/share/valid.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class TourRated extends StatefulWidget {
  const TourRated({Key key}) : super(key: key);

  @override
  State<TourRated> createState() => _TourRatedState();
}

class _TourRatedState extends State<TourRated> {
  List<Tour> _tourHasGone = List<Tour>();

  @override
  void initState() {
    super.initState();
    fetchTourUrl(hasRatedTour + EMAIL).then((dataFromServer) {
      setState(() {
        _tourHasGone = dataFromServer;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      width: MediaQuery.of(context).size.width,
      decoration: BoxDecoration(
          boxShadow: [
            BoxShadow(
              color: GreenColor.withOpacity(0.2),
              spreadRadius: 0,
              blurRadius: 5,
              offset: Offset(2, -4),
            )
          ],
          color: GreenColor,
          borderRadius: BorderRadius.only(
              topRight: Radius.circular(30), topLeft: Radius.circular(30))),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Padding(
            padding: const EdgeInsets.all(10.0),
            child: Text(
              'Danh sách tour đã đi',
              style: TextStyle(
                  fontSize: 20,
                  color: Colors.white,
                  fontWeight: FontWeight.w600),
            ),
          ),
          Container(
            height: 1,
            decoration: BoxDecoration(color: Colors.white),
          ),
          _tourHasGone.length == 0
              ? Container(
                  color: Colors.white,
                  height: MediaQuery.of(context).size.height * 0.74,
                  child: Center(
                    child: Text(
                      'Trống',
                      style:
                          TextStyle(fontSize: 20, fontWeight: FontWeight.w300),
                    ),
                  ),
                )
              : Container(
                  height: 116.0 * _tourHasGone.length,
                  decoration: BoxDecoration(
                    color: Colors.white,
                  ),
                  child: ListView.builder(
                    itemCount: _tourHasGone.length,
                    itemBuilder: (context, index) {
                      return Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Container(
                          height: 100,
                          decoration: BoxDecoration(
                              color: Colors.white,
                              borderRadius:
                                  BorderRadius.all(Radius.circular(30))),
                          child: Stack(
                            children: [
                              Container(
                                child: ClipRRect(
                                  borderRadius:
                                      BorderRadius.all(Radius.circular(30)),
                                  child: Image.network(
                                    _tourHasGone[index].hinhanh != ''
                                        ? IMG_DIR + _tourHasGone[index].hinhanh
                                        : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                                    height: MediaQuery.of(context).size.height,
                                    width: MediaQuery.of(context).size.width,
                                    fit: BoxFit.cover,
                                  ),
                                ),
                              ),
                              Container(
                                height: MediaQuery.of(context).size.height,
                                width: MediaQuery.of(context).size.width,
                                decoration: BoxDecoration(
                                    color: Colors.white24,
                                    borderRadius:
                                        BorderRadius.all(Radius.circular(30))),
                                child: Padding(
                                  padding:
                                      const EdgeInsets.fromLTRB(15, 10, 15, 10),
                                  child: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Container(
                                        child: Text(
                                          _tourHasGone[index].tentour,
                                          maxLines: 1,
                                          overflow: TextOverflow.ellipsis,
                                          softWrap: false,
                                          style: TextStyle(
                                              fontSize: 18,
                                              fontWeight: FontWeight.w600,
                                              color: Colors.black87),
                                        ),
                                      ),
                                      Spacer(),
                                      Row(
                                        children: [
                                          Spacer(),
                                          Text(
                                            DateFormat('dd/MM/yyyy').format(
                                                    DateTime.parse(
                                                        _tourHasGone[index]
                                                            .ngaybd)) +
                                                " - " +
                                                DateFormat('dd/MM/yyyy').format(
                                                    DateTime.parse(
                                                        _tourHasGone[index]
                                                            .ngaykt)),
                                            style: TextStyle(
                                                fontSize: 15,
                                                fontWeight: FontWeight.w500,
                                                color: Colors.black87),
                                          ),
                                          Spacer(),
                                        ],
                                      ),
                                      Spacer(),
                                      Row(
                                        children: [
                                          Spacer(),
                                          Text(
                                            NumberFormat.currency(
                                                    locale: 'vi', symbol: 'VND')
                                                .format(int.parse(
                                                    _tourHasGone[index]
                                                        .giatour)),
                                            style: TextStyle(
                                                fontSize: 20,
                                                fontWeight: FontWeight.w800,
                                                color: Colors.redAccent),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),
                              )
                            ],
                          ),
                        ),
                      );
                    },
                  ),
                )
        ],
      ),
    );
  }
}
