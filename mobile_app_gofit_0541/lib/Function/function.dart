import 'package:intl/intl.dart';
import 'package:shared_preferences/shared_preferences.dart';

Future<String> getData(String key) async {
  SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getString(key) ?? '';
}

// Menyimpan data ke Shared Preferences
Future<void> saveData(String key, String value) async {
  SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setString(key, value);
}

class DateFormatterForView{

  static String formatDayMonthYear(String dateString){
    // DateFormat dateFormat =  DateFormat('dd-MM-yyyy');

    DateTime date = DateTime.parse(dateString);

     // Dapatkan komponen tanggal yang diperlukan
    String day = date.day.toString().padLeft(2, '0');
    String month = date.month.toString().padLeft(2, '0');
    String year = date.year.toString();
  
    // Gabungkan komponen tanggal dengan tanda "-"
    String formattedDate = '$day-$month-$year';
    return formattedDate;
  }

  static String timeFormatHourMinute(String time){
    String afterFormat = 'mantap';

    return afterFormat;
  }
}

class CurrencyFormatter{
  static String rupiahFormatter(String duit){
  double amount = double.parse(duit);
  final formatter = NumberFormat.currency(locale: 'id_ID', symbol: 'Rp');
  return formatter.format(amount);
  }
}
