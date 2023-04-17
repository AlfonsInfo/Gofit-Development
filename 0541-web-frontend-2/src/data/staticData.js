class functionalMenu{
  
  constructor(title,description,imageLink,route){
    this.title =  title,
    this.description = description,    
    this.imageLink =  imageLink,
    this.route = route
  }

}

export const functionalKasir = [
  new functionalMenu('Olah Member',
  'Fitur ini memungkinkan pegawai untuk menambahkan, mengubah, mengupdate, dan menghapus data member.','../../src/assets/image/gym-membership-app.jpeg','member'),
  new functionalMenu('Reset Password Member','Fitur ini mendukung pegawai melayani member yang ingin melakukan reset password karena lupa','../../src/assets/image/reset-password.jpg','reset-password'),
  new functionalMenu('Transaksi','Fitur ini mendukung layanan transaksi seperti aktivasi membership, deposit uang, deposit kelas dan cetak struk','../../src/assets/image/transaction-gym.jpg','transaksi'),
  new functionalMenu('Presensi Member Gym','Fitur ini digunakan untuk konfirmasi kehadiran member gym','../../src/assets/image/presensi.jpg','presensi-member-gym'),
];


