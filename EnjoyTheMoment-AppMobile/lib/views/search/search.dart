import 'package:ejm/model/tours.dart';
import 'package:ejm/network/network_tour.dart';
import 'package:ejm/share/share.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:ejm/views/home/home.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class Search extends StatefulWidget {
  final String keyWord;
  const Search({Key key, this.keyWord}) : super(key: key);

  @override
  _SearchState createState() => _SearchState();
}

class _SearchState extends State<Search> {
  var searchController = TextEditingController();
  List<Tour> _list = List<Tour>();

  @override
  void initState() {
    super.initState();
    setState(() {
      fetchTourUrl(searchAPI + widget.keyWord).then((value) {
        setState(() {
          _list = value;
        });
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        leading: IconButton(
          onPressed: () => Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => MyHomePage(),
              )),
          icon: Icon(
            Icons.arrow_back,
            color: Colors.white,
          ),
        ),
        centerTitle: true,
        title: Text('Tìm kiếm'),
        backgroundColor: GreenColor,
      ),
      body: Container(
        child: ListView.builder(
          itemCount: _list.length + 1 + (_list.length == 0 ? 1 : 0),
          itemBuilder: (context, index) {
            return index == 0
                ? Padding(
                    padding: const EdgeInsets.all(10.0),
                    child: Row(
                      children: [
                        Container(
                            width: MediaQuery.of(context).size.width * 0.8,
                            child: TextFormField(
                              controller: searchController,
                              decoration: InputDecoration(
                                hintText: 'Nhập vào từ khóa...',
                              ),
                            )),
                        Spacer(),
                        IconButton(
                          onPressed: () {
                            setState(() {
                              fetchTourUrl(searchAPI + searchController.text)
                                  .then((value) {
                                setState(() {
                                  _list = value;
                                });
                              });
                            });
                          },
                          icon: Icon(
                            Icons.search,
                            size: 30,
                            color: GreenColor,
                          ),
                        )
                      ],
                    ),
                  )
                : _list.length == 0
                    ? Center(child: Text('Không có kết quả!', style: TextStyle(color: GreenColor, fontSize: 20),))
                    : Card(
                        child: MaterialButton(
                          onPressed: () => Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => DetailTour(
                                  tour: _list[index - 1],
                                ),
                              )),
                          child: Padding(
                            padding: const EdgeInsets.fromLTRB(8, 15, 8, 10),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  _list[index - 1].tentour,
                                  style: TextStyle(
                                      fontSize: 22,
                                      fontWeight: FontWeight.w500,
                                      color: Colors.black87),
                                ),
                                SizedBox(
                                  height: 4,
                                ),
                                Text(
                                  _list[index - 1].mota,
                                  style: TextStyle(
                                      color: Colors.grey, fontSize: 17),
                                ),
                                SizedBox(
                                  height: 10,
                                ),
                                Row(
                                  children: [
                                    Spacer(),
                                    Text(
                                      DateFormat('dd/MM/yyyy').format(
                                              DateTime.parse(
                                                  _list[index - 1].ngaybd)) +
                                          " - " +
                                          DateFormat('dd/MM/yyyy').format(
                                              DateTime.parse(
                                                  _list[index - 1].ngaykt)),
                                      style: TextStyle(fontSize: 18),
                                    ),
                                    Spacer(),
                                    Text(
                                      NumberFormat.currency(
                                              locale: 'vi', symbol: 'VND')
                                          .format(int.parse(
                                              _list[index - 1].giatour)),
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
                        ),
                      );
            ;
          },
        ),
      ),
    );
  }
}
