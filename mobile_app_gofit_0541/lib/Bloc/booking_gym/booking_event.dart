part of 'booking_gym_bloc.dart';


//* Representasi Abstrak Semua Event Pada Form BookingGym
abstract class BookingGymEvent{}


//* Representasi Evnt perubahan Date
class DateChanged extends BookingGymEvent{
  final String? date;
  DateChanged({this.date});
}

//* Representasi Event perubahan password
class SesiChanged extends BookingGymEvent{
  final String? sesi;
  SesiChanged({this.sesi});
}


//* Booking Submitted
class BookingSubmitted extends BookingGymEvent{
  final String? idMember;
  BookingSubmitted({this.idMember});
}
