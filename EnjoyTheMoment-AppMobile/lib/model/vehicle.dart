class Vehicle {
  String tenphuongtien;

  Vehicle({this.tenphuongtien});

  Vehicle.fromJson(Map<String, dynamic> json) {
    tenphuongtien = json['tenphuongtien'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['tenphuongtien'] = this.tenphuongtien;
    return data;
  }
}
