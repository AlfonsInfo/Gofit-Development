class User{
  final String idPengguna;
  final String username;
  final String role;

  User({required this.idPengguna, required this.username, required this.role});
  factory User.fromJson(Map<String,dynamic> json){
    return User(
      idPengguna: json['id_pengguna']?.toString() ?? '',
      username: json['username']?.toString() ?? '',
      role : json['role']?.toString() ?? '',
    );
  }
}