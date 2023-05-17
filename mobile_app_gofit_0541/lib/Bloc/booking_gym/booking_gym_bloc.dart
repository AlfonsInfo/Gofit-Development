import 'dart:developer';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile_app_gofit_0541/Bloc/booking_gym/form_booking_gym.dart';
import 'package:mobile_app_gofit_0541/Repository/repo_booking_gym.dart';

import 'package:mobile_app_gofit_0541/Repository/repo_sesi.dart';
import 'package:mobile_app_gofit_0541/Models/sesi_gym.dart';


part 'booking_event.dart';
part 'booking_state.dart';


class BookingGymBloc extends Bloc<BookingGymEvent, BookingGymState>{
  BookingGymRepository bookingGymRepo = BookingGymRepository();


  BookingGymBloc() : super(BookingGymState()){
    //* on Event state ()
    on<DateChanged>(_onDateChanged);
    on<SesiChanged>(_onSesiChanged);
    on<BookingSubmitted>(_onBookingSubmitted);
  }

  //* Mencatat perubahan pada form email
  _onDateChanged(DateChanged event, Emitter<BookingGymState> emit) 
  {
    emit(state.copyWith(dateBooking: event.date));
    // inspect(state.dateBooking);
  }
  //* Mencatat perubahan pada form email
  _onSesiChanged(SesiChanged event, Emitter<BookingGymState> emit) 
  {
    emit(state.copyWith( sesi: event.sesi));
    // inspect(state.sesi);
  }


  //* saat tombol submit di pencet
  _onBookingSubmitted (BookingSubmitted event, Emitter<BookingGymState> emit) async
  {
    //*State menjadi submitting
    emit(state.copyWith(idMember: event.idMember , formStatus: FormSubmitting()));    
    try{
      //*request login
      final response = await bookingGymRepo.store( IdMember: state.idMember , bookingDate: state.dateBooking ,idSesi: state.sesi );
      emit(state.copyWith(message: response[0]));
      if(response[1] == true){
      emit(state.copyWith(formStatus: SubmissionSuccess()));
      }
      if(response[1] == false){
      emit(state.copyWith(formStatus: SubmissionFailed()));
      }
    }catch(e){
      emit(state.copyWith(formStatus: SubmissionFailed(exception: e as Exception)));
    }
  }



}