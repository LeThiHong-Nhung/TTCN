import 'package:ejm/share/url_api.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:intl/intl.dart';
import 'package:ejm/model/tours.dart';
import 'package:ejm/network/network_tour.dart';
import 'package:ejm/share/share.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Tours extends StatefulWidget {
  const Tours({Key key}) : super(key: key);

  @override
  _ToursState createState() => _ToursState();
}

class _ToursState extends State<Tours> {
  List<Tour> _tours = List<Tour>();
  List<Tour> _toursDisplay = List<Tour>();

  Icon customIcon = const Icon(Icons.search);
  Widget customSearchBar = const Text('Danh sách tour');

  @override
  void initState() {
    super.initState();
    fetchTour().then((value) {
      setState(() {
        _tours.addAll(value);
        _toursDisplay = _tours;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: GreenColor,
        leading: IconButton(
          icon: Icon(Icons.arrow_back),
          onPressed: () => Navigator.pop(context),
        ),
        title: TextField(
          decoration: InputDecoration(
            hintText: 'Nhập vào tên tour...',
            hintStyle: TextStyle(
              color: Colors.white,
              fontSize: 18,
              fontStyle: FontStyle.italic,
            ),
            border: InputBorder.none,
          ),
          style: TextStyle(
            color: Colors.white,
          ),
          onChanged: (text) {
            if (text != null) {
              text = text.toLowerCase();

              setState(() {
                _toursDisplay = _tours.where((tour) {
                  var tourTitle = tour.tentour.toLowerCase();
                  return tourTitle.contains(text);
                }).toList();
              });
            }
          },
        ),
        automaticallyImplyLeading: false,
        centerTitle: true,
      ),
      body: Container(
        padding: EdgeInsets.only(left: 4, right: 4),
        child: ListView.builder(
          // controller: _scrollController,
          itemCount: _toursDisplay.length,
          shrinkWrap: true,
          itemBuilder: (context, index) {
            return MaterialButton(
              onPressed: () {
                Navigator.push(context, MaterialPageRoute(builder: (context) => DetailTour(tour: _toursDisplay[index]),));
              },
              padding: const EdgeInsets.all(0),
              child: Card(
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.only(
                    topLeft: Radius.circular(20),
                    topRight: Radius.circular(20),
                  ),
                ),
                child: Column(
                  children: [
                    ClipRRect(
                      borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(20),
                        topRight: Radius.circular(20),
                      ),
                      child: Image.network(
                        _toursDisplay[index].hinhanh != ''
                            ? IMG_DIR + _toursDisplay[index].hinhanh
                            : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                        height: 70,
                        width: MediaQuery.of(context).size.width,
                        fit: BoxFit.cover,
                      ),
                    ),
                    Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            _toursDisplay[index].tentour,
                            style: TextStyle(
                                fontSize: 22,
                                fontWeight: FontWeight.w500,
                                color: Colors.black87),
                          ),
                          SizedBox(
                            height: 4,
                          ),
                          Text(
                            _toursDisplay[index].mota,
                            style: TextStyle(color: Colors.grey, fontSize: 17),
                          ),
                          SizedBox(
                            height: 10,
                          ),
                          Row(
                            children: [
                              Spacer(),
                              Text(
                                DateFormat('dd/MM/yyyy').format(DateTime.parse(
                                        _toursDisplay[index].ngaybd)) +
                                    " - " +
                                    DateFormat('dd/MM/yyyy').format(
                                        DateTime.parse(
                                            _toursDisplay[index].ngaykt)),
                                style: TextStyle(fontSize: 18),
                              ),
                              Spacer(),
                              Text(
                                NumberFormat.currency(locale: 'vi', symbol: 'VND')
                                    .format(
                                        int.parse(_toursDisplay[index].giatour)),
                                style: TextStyle(
                                    fontSize: 20,
                                    fontWeight: FontWeight.w700,
                                    color: GreenColor),
                              ),
                            ],
                          )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }
}
