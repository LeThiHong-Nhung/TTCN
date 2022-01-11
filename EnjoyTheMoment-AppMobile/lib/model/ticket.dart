class Ticket {
  String matour;
  String tentour;
  String ngaybd;
  String ngaykt;
  String giatour;
  String khachsan;
  String mota;
  String tinhtrang;
  String hinhanh;
  String sove;

  Ticket(
      {this.matour,
      this.tentour,
      this.ngaybd,
      this.ngaykt,
      this.giatour,
      this.khachsan,
      this.mota,
      this.tinhtrang,
      this.hinhanh,
      this.sove});

  Ticket.fromJson(Map<String, dynamic> json) {
    matour = json['matour'];
    tentour = json['tentour'];
    ngaybd = json['ngaybd'];
    ngaykt = json['ngaykt'];
    giatour = json['giatour'];
    khachsan = json['khachsan'];
    mota = json['mota'];
    tinhtrang = json['tinhtrang'];
    hinhanh = json['hinhanh'];
    sove = json['sove'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['matour'] = this.matour;
    data['tentour'] = this.tentour;
    data['ngaybd'] = this.ngaybd;
    data['ngaykt'] = this.ngaykt;
    data['giatour'] = this.giatour;
    data['khachsan'] = this.khachsan;
    data['mota'] = this.mota;
    data['tinhtrang'] = this.tinhtrang;
    data['hinhanh'] = this.hinhanh;
    data['sove'] = this.sove;
    return data;
  }
}
