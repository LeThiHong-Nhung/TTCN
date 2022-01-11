import 'package:ejm/share/url_api.dart';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:ejm/model/tours.dart';

List<Tour> parseTour(String responseBody) {
  var list = json.decode(responseBody) as List<dynamic>;
  List<Tour> tours = list.map((model) => Tour.fromJson(model)).toList();
  return tours;
}

Future<List<Tour>> fetchTour() async {
  final response = await http.get(Uri.parse(tourApi));
  if (response.statusCode == 200) {
    return compute(parseTour, response.body);
  } else {
    throw Exception("Request API Error");
  }
}

Future<List<Tour>> fetchTourPopular() async {
  final response = await http.get(Uri.parse(tourPopularApi));
  if (response.statusCode == 200) {
    return compute(parseTour, response.body);
  } else {
    throw Exception("Request API Error");
  }
}

Future<List<Tour>> fetchTourUrl(String url) async {
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 200) {
    return compute(parseTour, response.body);
  } else {
    throw Exception("Request API Error");
  }
}