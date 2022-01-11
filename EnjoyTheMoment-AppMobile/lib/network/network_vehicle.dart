import 'dart:convert';

import 'package:ejm/model/vehicle.dart';
import 'package:ejm/share/url_api.dart';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;

List<Vehicle> parseVehicle(String responseBody) {
  var list = json.decode(responseBody) as List<dynamic>;
  List<Vehicle> vehicles = list.map((model) => Vehicle.fromJson(model)).toList();
  return vehicles;
}

Future<List<Vehicle>> fetchVehicle(String id) async {
  final response = await http.get(Uri.parse(vehicleAPi + id));
  if (response.statusCode == 200) {
    return compute(parseVehicle, response.body);
  } else {
    throw Exception("Request API Error");
  }
}