part of 'booking_gym_bloc.dart';


class BookingGymState{
  // List<Sesi>? daftarSesi; 
  final daftarSesi =  SesiRepository();


  List<Sesi>? _defaultSesi;

  Future<List<Sesi>?> fetchDefaultSesi() async {
    return await SesiRepository().getSesi();
  }

  List<Sesi>? get defaultSesi {
    if (_defaultSesi == null) {
      fetchDefaultSesi().then((sesiList) {
        _defaultSesi = sesiList;
      });
    }
    return _defaultSesi;
  }
  
  
  final FormSumbissionStatus formStatus;

  // final String role;



  BookingGymState({
    // this.daftarSesi = const SesiRepository().getSesi(),
    this.formStatus = const InitialFormStatus(),
  });

  BookingGymState copyWith({String? username, String? password, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? role,User? user, Instruktur? instruktur, Pegawai? pegawai, Member? member}){
    return BookingGymState(
      formStatus: formStatus ?? this.formStatus,
    );
  }
}