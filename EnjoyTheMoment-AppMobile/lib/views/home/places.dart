import 'package:ejm/model/places.dart';
import 'package:ejm/network/network_place.dart';
import 'package:ejm/share/url_api.dart';
import 'package:ejm/views/search/search.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Places extends StatefulWidget {
  final String matour;
  const Places({Key key, this.matour}) : super(key: key);

  @override
  _PlacesState createState() => _PlacesState();
}

class _PlacesState extends State<Places> {
  List<Place> _places = List<Place>();

  @override
  void initState() {
    super.initState();
    networkRequestPlace.fetchPlace(widget.matour).then((dataFromServer) {
      setState(() {
        _places = dataFromServer;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 230,
      child: ListView.builder(
        itemCount: _places.length,
        shrinkWrap: true,
        scrollDirection: Axis.horizontal,
        itemBuilder: (context, index) {
          return TextButton(
            onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => Search(
                    keyWord: _places[index].tendiemden,
                  ),
                )),
            child: Container(
              decoration: BoxDecoration(
                boxShadow: [
                  BoxShadow(
                    color: Colors.grey.withOpacity(0.1),
                    spreadRadius: 5,
                    blurRadius: 10,
                    offset: Offset(0, 8), // changes position of shadow
                  ),
                ],
              ),
              child: Stack(
                children: [
                  ClipRRect(
                    borderRadius: BorderRadius.circular(16),
                    child: Image.network(
                      _places[index].hinhanh != null
                          ? IMG_DIR + _places[index].hinhanh
                          : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                      height: 230,
                      width: 160,
                      fit: BoxFit.cover,
                    ),
                  ),
                  Container(
                    height: 230,
                    width: 160,
                    child: Column(
                      children: [
                        Spacer(),
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Container(
                                width: 95,
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      _places[index].tendiemden,
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                      softWrap: false,
                                      style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.w600,
                                          color: Colors.white),
                                    ),
                                    Text(
                                      '${_places[index].relatedTour} Tours',
                                      style: TextStyle(
                                          fontSize: 18,
                                          fontWeight: FontWeight.w800,
                                          color: Colors.white),
                                    )
                                  ],
                                ),
                              ),
                              IconButton(
                                  onPressed: () => showDialog<String>(
                                        context: context,
                                        builder: (BuildContext context) =>
                                            AlertDialog(
                                          title:
                                              Text(_places[index].tendiemden),
                                          content: Container(
                                            height: MediaQuery.of(context)
                                                    .size
                                                    .height *
                                                0.4,
                                            width: MediaQuery.of(context)
                                                    .size
                                                    .width *
                                                0.8,
                                            decoration: BoxDecoration(
                                              borderRadius: BorderRadius.all(
                                                  Radius.circular(40)),
                                            ),
                                            child: Column(
                                              children: [
                                                ClipRRect(
                                                  borderRadius:
                                                      BorderRadius.all(
                                                          Radius.circular(20)),
                                                  child: Image.network(
                                                    _places[index].hinhanh !=
                                                            null
                                                        ? IMG_DIR + _places[index].hinhanh
                                                        : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8nqr6w_qWXwZz5tQlz4Wf2qyYdBYRLHXYQ&usqp=CAU',
                                                    width:
                                                        MediaQuery.of(context)
                                                            .size
                                                            .width,
                                                    fit: BoxFit.cover,
                                                  ),
                                                ),
                                                SizedBox(
                                                  height: 10,
                                                ),
                                                Spacer(),
                                                Center(
                                                  child: Container(
                                                    height: 95,
                                                    child:
                                                        SingleChildScrollView(
                                                      child: Text(
                                                        _places[index].mota,
                                                        style: TextStyle(
                                                            fontSize: 17,
                                                            fontWeight:
                                                                FontWeight.w400,
                                                            color: Colors.grey),
                                                      ),
                                                    ),
                                                  ),
                                                ),
                                                Spacer(),
                                              ],
                                            ),
                                          ),
                                          actions: <Widget>[
                                            TextButton(
                                              onPressed: () =>
                                                  Navigator.pop(context, 'Hủy'),
                                              child: const Text('Hủy'),
                                            ),
                                            TextButton(
                                              onPressed: () => Navigator.push(
                                                  context,
                                                  MaterialPageRoute(
                                                    builder: (context) =>
                                                        Search(
                                                      keyWord: _places[index]
                                                          .tendiemden,
                                                    ),
                                                  )),
                                              child: const Text(
                                                  'Xem tour liên quan'),
                                            ),
                                          ],
                                        ),
                                      ),
                                  icon: Icon(
                                    Icons.visibility,
                                    color: Colors.white,
                                  ))
                            ],
                          ),
                        ),
                      ],
                    ),
                  )
                ],
              ),
            ),
          );
        },
      ),
    );
  }
}
