class Pengguna{
  final String idPengguna;
  final String username;
  final String role;

  Pengguna({required this.idPengguna, required this.username, required this.role});
  factory Pengguna.fromJson(Map<String,dynamic> json){
    return Pengguna(
      idPengguna: json['id_pengguna']?.toString() ?? '',
      username: json['username']?.toString() ?? '',
      role : json['role']?.toString() ?? '',
    );
  }
}