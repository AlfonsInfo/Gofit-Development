import Swal from 'sweetalert2'


export const CustomDateTimeFormatter = {
    reverseDate(tanggal, separator){
        var tanggal_split_space = tanggal.split(" ")[0];
        var tanggal_baru = tanggal_split_space.split("-").reverse().join(separator);
        return tanggal_baru;
    },
    
    dateTimeSlash(tanggalWaktu,separator){
        var dateTimeSplit = tanggalWaktu.split(" ");
        var tanggal = dateTimeSplit[0];
        var waktu = dateTimeSplit[1].split(":").slice(0, 2).join(":");
        var tanggalBaru = tanggal.split(separator).reverse().join("-");
        var formattedDateTime = tanggalBaru + " " + waktu;
        return formattedDateTime;
    }

}

export const CurrencyFormatter = {
    
}




export const customSwal = async (message,icon,confirmButtonColor,confirmButtonText = 'Okay', callBackAction, data) => {

    // try{
    const result = await Swal.fire({
      title: message ,
      icon: icon,
      showCancelButton: true,
      confirmButtonColor: confirmButtonColor,
      confirmButtonText: confirmButtonText,
      cancelButtonText: 'Batal',
    })
  if (result.isConfirmed) {
    callBackAction(data)
  }
}


export const customSwalSuccess = async(title) => {
    Swal.fire({
        title: title,
        icon: 'success',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
      })
}


export const customSwalFail = async(title) => {
    Swal.fire({
        title: title,
        icon: 'failed',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
      })
}