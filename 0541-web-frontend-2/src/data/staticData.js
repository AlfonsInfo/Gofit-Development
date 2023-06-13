class functionalMenu{
  
  constructor(title,description,imageLink,route){
    this.title =  title,
    this.description = description,    
    this.imageLink =  imageLink,
    this.route = route
  }

}




export const getImageUrl = (path) => {
  return new URL(`../../src/assets/${path}`, import.meta.url).href;
};
    


export const functionalKasir = [
  new functionalMenu('Olah Member',
  'Fitur ini memungkinkan pegawai untuk menambahkan, mengubah, mengupdate, dan menghapus data member.',getImageUrl('image/gym-membership-app.jpeg'),'member'),
  new functionalMenu('Reset Password Member','Fitur ini mendukung pegawai melayani member yang ingin melakukan reset password karena lupa','../../src/assets/image/reset-password.jpg','member-reset-password'),
  new functionalMenu('Transaksi','Fitur ini mendukung layanan transaksi seperti aktivasi membership, deposit uang, deposit kelas dan cetak struk','../../src/assets/image/transaction-gym.jpg','transaksi-member',),
  new functionalMenu('Presensi Member','Fitur ini digunakan untuk konfirmasi kehadiran member gym dan member kelas','../../src/assets/image/presensi.jpg','presensi-member','presensi-member'),
  new functionalMenu('Sistem','Fitur ini digunakan untuk mendukung kinerja sistem website dan apps','../../src/assets/image/presensi.jpg','presensi-member','presensi-member'),
];


export const functionalAdmin = [
  new functionalMenu('Olah Data Instruktur','Fitur Olah Data Instruktur (Menambahkan, Menampilkan, Mengubah, Menghapus) data instruktur','../../src/assets/image/instruktor.jpg','instruktur')
]
export const functionalMO = [
  new functionalMenu('Olah Jadwal Umum','Fitur pengolah data Jadwal Secara Umum, Manajer Operasional bisa menambahkankan jadwal , mengupdate jadwal, menampilkan dan menghapus jadwal','../../assets/image/schedule.jpg','jadwal-umum'),
  new functionalMenu('Olah Jadwal Harian','Fitur Generate Jadwal untuk setiap 1 minggu, Fitur ini dibutuhkan untuk mendukung operasional gym setiap minggu','../../src/assets/image/daily-schedule.jpg','jadwal-harian'),
  new functionalMenu('Perijinan Instruktur','Fitur pengolah data perijinan instruktur, MO bisa memantau perijinan instruktur, melakukan konfirmasi perijinan.','../../src/assets/image/perijinan.jpeg','ijin-instruktur','ijin-instruktur'),
  new functionalMenu('Laporan','Fitur Laporan digunakan untuk memantau operasional Gym secara keseluruhan.','../../src/assets/image/report.jpg','laporan')
]

export const menuPresensi = [
  new functionalMenu('Presensi Member Gym', 'Fitur ini digunakan untuk mengecek dan mengkonfirmasi kehadiran peserta gym' , '../../src/assets/image/presensi.jpg','presensi-member-gym'),
  new functionalMenu('Presensi Peserta Kelas', 'Fitur ini digunakan untuk mengecek kehadiran member disetiap kelas yang diikutinnya' , '../../src/assets/image/presensi.jpg','presensi-member-kelas')
]
export const menuTransaksi = [
  new functionalMenu('Transaksi Aktivasi', 'Fitur ini digunakan untuk melakukan aktivasi akun member' , '../../src/assets/image/activate.png','transaksi-aktivasi'),
  new functionalMenu('Transaksi Deposit Uang', 'Fitur ini digunakan untuk mengecek kehadiran member disetiap kelas yang diikutinnya' , '../../src/assets/image/save-on-fitness.jpeg','transaksi-deposit-uang'),
  new functionalMenu('Transaksi Deposit Paket', 'Fitur ini digunakan untuk mengecek kehadiran member disetiap kelas yang diikutinnya' , '../../src/assets/image/classgym.jpeg','transaksi-deposit-kelas')
]


export const menuLaporan = [
  new functionalMenu('Pendapatan Bulanan Per Tahun', 'Fitur ini digunakan untuk menghasilkan laporan pendapatan bulanan dalam suatu tahun' , '../../src/assets/image/report.jpg','laporan-tahunan'),
  new functionalMenu('Laporan Aktivitas Kelas Bulanan', 'Fitur ini digunakan untuk menghasilkan aktivitas kelas dalam satu bulan' , '../../src/assets/image/classgym.jpeg','laporan-kelas-bulanan'),
  new functionalMenu('Laporan Aktivitas Gym Bulanan', 'Fitur ini digunakan untuk menghasilkan aktivitas gym dalam satu bulan' , '../../src/assets/image/background-1.jpg','laporan-gym-bulanan'),
  new functionalMenu('Kinerja Instruktur Bulanan', 'Fitur ini digunakan untuk menampilkan kinerja instruktur' , '../../src/assets/image/instruktor.jpg','laporan-instruktur-bulanan')
  // new functionalMenu('Laporan Aktivitas Kelas Bulanan', 'Fitur ini digunakan untuk menghasilkan aktivitas kelas dalam satu bulan' , '../../src/assets/image/classgym.jpeg','transaksi-deposit-kelas'),
]
