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
  new functionalMenu('Reset Password Member','Fitur ini mendukung pegawai melayani member yang ingin melakukan reset password karena lupa','../../src/assets/image/reset-password.jpg','member-reset-password'),
  new functionalMenu('Transaksi','Fitur ini mendukung layanan transaksi seperti aktivasi membership, deposit uang, deposit kelas dan cetak struk','../../src/assets/image/transaction-gym.jpg','transaksi',),
  new functionalMenu('Presensi Member','Fitur ini digunakan untuk konfirmasi kehadiran member gym dan member kelas','../../src/assets/image/presensi.jpg','presensi-member-gym','presensi-member-gym'),
];


export const functionalAdmin = [
  new functionalMenu('Olah Data Instruktur','Fitur pengolah data Admin, Admin bisa menambahkan data instruktur, mengupdate, menampilkan dan menghapus data instruktur','../../src/assets/image/instruktor.jpg','instruktur')
]
export const functionalMO = [
  new functionalMenu('Olah Jadwal Umum','Fitur pengolah data Admin, Admin bisa menambahkan data instruktur, mengupdate, menampilkan dan menghapus data instruktur','../../src/assets/image/schedule.jpg','jadwal-umum'),
  new functionalMenu('Olah Jadwal Harian','Fitur pengolah data Admin, Admin bisa menambahkan data instruktur, mengupdate, menampilkan dan menghapus data instruktur','../../src/assets/image/daily-schedule.jpg','jadwal-harian'),
  new functionalMenu('Perijinan Instruktur','Fitur pengolah data Admin, Admin bisa menambahkan data instruktur, mengupdate, menampilkan dan menghapus data instruktur','../../src/assets/image/perijinan.jpeg','ijin-instruktur','ijin-instruktur'),
  new functionalMenu('Laporan','Fitur pengolah data Admin, Admin bisa menambahkan data instruktur, mengupdate, menampilkan dan menghapus data instruktur','../../src/assets/image/report.jpg','laporan')
]
