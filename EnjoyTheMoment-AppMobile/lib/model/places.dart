class Place {
  String madiemden;
  String tendiemden;
  String mota;
  String hinhanh;
  String relatedTour;

  Place(
      {this.madiemden,
        this.tendiemden,
        this.mota,
        this.hinhanh,
        this.relatedTour});

  Place.fromJson(Map<String, dynamic> json) {
    madiemden = json['madiemden'];
    tendiemden = json['tendiemden'];
    mota = json['mota'];
    hinhanh = json['hinhanh'];
    relatedTour = json['related_tour'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['madiemden'] = this.madiemden;
    data['tendiemden'] = this.tendiemden;
    data['mota'] = this.mota;
    data['hinhanh'] = this.hinhanh;
    data['related_tour'] = this.relatedTour;
    return data;
  }
}
