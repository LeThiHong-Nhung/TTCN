import 'package:ejm/share/share.dart';
import 'package:ejm/share/valid.dart';
import 'package:ejm/views/detail_tour/detail.tour.dart';
import 'package:ejm/views/detail_user/detail.user.dart';
import 'package:ejm/views/favorite/favorite.dart';
import 'package:ejm/views/home/places.dart';
import 'package:ejm/views/home/popular.dart';
import 'package:ejm/views/search/search.dart';
import 'package:ejm/views/tour/tour.dart';
import 'package:ejm/views/user_behavior/login.dart';
import 'package:flutter/material.dart';

class MyHomePage extends StatefulWidget {
  const MyHomePage({Key key}) : super(key: key);

  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {

  int currentTab = 0;
  final List<Widget> screens = [
    Home(),
    Favorite(),
    Search(keyWord: '',),
    // DetailTour()
  ];
  final PageStorageBucket bucket = PageStorageBucket();
  Widget currentScreen = Home();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: PageStorage(
        child: currentScreen,
        bucket: bucket,
      ),
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          boxShadow: [
            BoxShadow(
              color: BlackText.withOpacity(0.1),
              spreadRadius: 0,
              blurRadius: 5,
              offset: Offset(0, -4), // changes position of shadow
            ),
          ],
        ),
        child: Padding(
          padding: const EdgeInsets.only(top: 10, bottom: 10, left: 20, right: 20),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              IconButton(
                icon: Icon(
                  Icons.home,
                  size: 35,
                  color: currentTab == 0 ? GreenColor :  BlackText,
                ),
                onPressed: () {
                  setState(() {
                    currentTab = 0;
                    currentScreen = Home();
                  });
                },
              ),
              IconButton(
                icon: Icon(
                  Icons.favorite,
                  size: 35,
                  color: currentTab == 1 ? GreenColor :  BlackText,
                ),
                onPressed: () {
                  if(EMAIL != null) {
                    setState(() {
                      currentTab = 1;
                      currentScreen = Favorite();
                    });
                  } else {
                    Navigator.push(context, MaterialPageRoute(builder: (context) => Login(),));
                  }
                },
              ),
              IconButton(
                icon: Icon(
                  Icons.search,
                  size: 35,
                  color: currentTab == 2 ? GreenColor :  BlackText,
                ),
                onPressed: () {
                  setState(() {
                    currentTab = 2;
                    currentScreen = Search(keyWord: '',);
                  });
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class Home extends StatefulWidget {
  const Home({Key key}) : super(key: key);

  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        leading: Container(
          padding: EdgeInsets.all(4),
          child: IconButton(
            icon: Icon(Icons.person),
            color: GreenColor,
            onPressed: ()  {
              if(EMAIL == null){
                Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => Login(),
                    ));
              } else {
                Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => DetailUser(),
                    ));
              }
            },
          ),
        ),
        backgroundColor: Colors.white,
        centerTitle: true,
        title: Text(
          'EnjoyTheMoment',
          style: TextStyle(color: BlackText, fontWeight: FontWeight.w600),
        ),
        elevation: 0.0,
      ),
      body: SingleChildScrollView(
        child: Container(
          padding: EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Tìm tour tốt nhất cho bạn',
                style: TextStyle(
                  fontSize: 30,
                  fontWeight: FontWeight.w700,
                  color: BlackText,
                ),
              ),
              Padding(
                padding: const EdgeInsets.fromLTRB(0, 10, 0, 10),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Những Địa Điểm',
                      style: TextStyle(
                          color: BlackText,
                          fontSize: 20,
                          fontWeight: FontWeight.w600),
                    ),
                    // TextButton(
                    //   child: Text(
                    //     'View all',
                    //     style: TextStyle(
                    //         color: GreenColor,
                    //         fontSize: 18,
                    //         fontWeight: FontWeight.w700),
                    //   ),
                    //   onPressed: () {},
                    // ),
                  ],
                ),
              ),
              Places(matour:  '',),
              Padding(
                padding: const EdgeInsets.fromLTRB(0, 10, 0, 10),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Tour phổ biến',
                      style: TextStyle(
                          color: BlackText,
                          fontSize: 20,
                          fontWeight: FontWeight.w600),
                    ),
                    TextButton(
                      child: Text(
                        'Xem tất cả',
                        style: TextStyle(
                            color: GreenColor,
                            fontSize: 18,
                            fontWeight: FontWeight.w700),
                      ),
                      onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (context) => Tours(),)),
                    ),
                  ],
                ),
              ),

              PopularTour(),
            ],
          ),
        ),
      ),
    );
  }
}



