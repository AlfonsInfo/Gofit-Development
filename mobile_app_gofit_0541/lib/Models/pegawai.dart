class Pegawai{
  //*Attribut
  String? idPegawai;
  String? idPengguna;
  String? namaPegawai;
  String? jabatanPegawai;
  String? tglLahir;
  String? noTelp;
  String? alamatPegawai;

  
  //* Constructor
  Pegawai({
    this.idPegawai,
    this.idPengguna,
    this.namaPegawai,
    this.jabatanPegawai,
    this.tglLahir,
    this.noTelp,
    this.alamatPegawai,
  });

  factory Pegawai.fromJson(Map<String,dynamic> json){
    return Pegawai(
      idPegawai: json['id_pegawai']?.toString() ?? '',
      idPengguna: json['id_pengguna']?.toString() ?? '',
      namaPegawai: json['nama_pegawai']?.toString() ?? '',
      jabatanPegawai : json['jabatan_pegawai']?.toString() ?? '',
      tglLahir: json['tgl_lahir_pegawai']?.toString() ?? '',
      noTelp: json['no_telp_pegawai']?.toString() ?? '',
      alamatPegawai: json['alamat_pegawai']?.toString() ?? '',
    );
  }

  // Map mapJson(String key) => json[key]?.toString() ??  '';


}



// {
//     "message": "Autenthicated",
//     "user": {
//         "id_pengguna": 21,
//         "username": "mo_ganteng1",
//         "role": "pegawai",
//         "created_at": "2023-04-01T17:54:35.000000Z",
//         "updated_at": "2023-04-02 00:54:35",
//         "deleted_at": null
//     },
//     "pegawai": {
//         "id_pegawai": "P03",
//         "id_pengguna": 21,
//         "nama_pegawai": "Adee",
//         "jabatan_pegawai": "MO",
//         "tgl_lahir_pegawai": "1998-01-22 00:00:00",
//         "no_telp_pegawai": "20",
//         "alamat_pegawai": "0811123232321",
//         "created_at": "2023-04-01T17:54:35.000000Z",
//         "updated_at": "2023-04-01T17:54:35.000000Z",
//         "deleted_at": null
//     },
//     "token_type": "Bearer",
//     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWI0YTE3MzRkMTQ5NjIxNjg3YTg2Mjg5NTBlZDUxNmFlZjFmZmYxNzdlZTVlYmI2MjMwNzE0NWM1NWE3OTkxZTUxMzE1ODAzMTdkMjAwODYiLCJpYXQiOjE2ODM3NzU4MDUuMTQ2Nzg2LCJuYmYiOjE2ODM3NzU4MDUuMTQ2Nzg4LCJleHAiOjE3MTUzOTgyMDUuMTMwOTA1LCJzdWIiOiIyMSIsInNjb3BlcyI6W119.iisGMYGCRpqaUSSeIcSuqyfp2mjuOJUhGoQZIX249h-dyv_vIUWmdASnuexzFL6vJZkvv5raLHaCq5fH-guI7e1rYZdR4kYTJR3mDDdAwyZzA7kq-euRX0Z86PtZs3yapFFeek-5jntNt08lbduJKFJqwZNqkBibrxq1DSLDBwFLb5LzjNLGHFeZeg3WMO_S4c8vGreSJ3FgIRWScxtZ8YILZtO7TXrG0tfPtHeRTwu27-MLikw1xL-EBclleIs1t2TyGDYVwCJzlC7v_hfWVPHqNP3YYGezrUW2ys9NVQGvYyS8v8vRvQbF45HgLNFZ0Gjj3Fqudq33b6S9C_W0ocpr95_7GbOewfwLxwvqzBvjB-wUkMbko0QATCMVlb5wgmZHBI3dWBBnZIH8vzLdxvwbUMuch-5psrDeNpzGiONL6ahuk40N_y4PNiysN3a-D7NWxk0Mp5YegCz4bqgjHP0AupugHjTEBBwhbqzoSXM3FmqdVgk-8jseRFSKoQEnan7jPdmnKkVvnoiYpnVUmyXlpsNA0Ehzi4ri6vOBf12yE5QaJKaNB2xvaRWh0Jfy2hTe62E0jdshzexkRq9PH_UYGbMiQ4mEfFgC-BMetEsDAQ_Tt8E2flcnGJsZ5lx5LEzrF8FhHtQxBCA9jbOq05hucTQp9yyOpfpPNB9wS4M"
// }