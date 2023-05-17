part of 'booking_gym_bloc.dart';


class BookingGymState{
  final daftarSesi =  SesiRepository();
  List<Sesi>? _defaultSesi;  
  final FormSumbissionStatus formStatus;
  final String idMember;
  final String dateBooking;
  final String sesi;
  final String message;




  BookingGymState({
    this.idMember = '',
    this.dateBooking = '',
    this.sesi = '',
    this.message = '',
    this.formStatus = const InitialFormStatus(),
  });

  BookingGymState copyWith({String? dateBooking, String? sesi,String? idMember, FormSumbissionStatus? formStatus = const InitialFormStatus(), String? message}){
    return BookingGymState(
      dateBooking: dateBooking ?? this.dateBooking,
      sesi: sesi ?? this.sesi,
      message: message ?? this.message,
      formStatus: formStatus ?? this.formStatus,
      idMember:  idMember ?? this.idMember
    );
  }
}
  // Future<List<Sesi>?> fetchDefaultSesi() async {
  //   return await SesiRepository().getSesi();
  // }

  // List<Sesi>? get defaultSesi {
  //   if (_defaultSesi == null) {
  //     fetchDefaultSesi().then((sesiList) {
  //       _defaultSesi = sesiList;
  //     });
  //   }
  //   return _defaultSesi;
  // }