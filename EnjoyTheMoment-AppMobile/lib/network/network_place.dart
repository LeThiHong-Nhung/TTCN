import 'dart:convert';

import 'package:ejm/model/places.dart';
import 'package:ejm/share/url_api.dart';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;

class networkRequestPlace {
  static List<Place> parsePlace(String responseBody) {
    var list = json.decode(responseBody) as List<dynamic>;
    List<Place> places = list.map((model) => Place.fromJson(model)).toList();
    return places;
  }

  static Future<List<Place>> fetchPlace(String matour) async {
    String url;
    if (matour != '')
      url = placeAPi + '?id=' + matour;
    else
      url = placeAPi;
    final response = await http.get(Uri.parse(url));
    if (response.statusCode == 200) {
      return compute(parsePlace, response.body);
    } else if (response.statusCode == 404) {
      throw Exception('Not found!');
    } else {
      throw Exception('Can\'t get this api');
    }
  }
}
