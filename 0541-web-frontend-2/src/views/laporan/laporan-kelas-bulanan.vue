<!-- eslint-disable no-undef -->
<script>
import { HomeNavbar, useRouter,  $toast, defineComponent, BackButton ,ref } from '@/plugins/global.js'



  export default defineComponent({  
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },
    
    data(){
        return{
            router : useRouter(),
            dataLaporan: ref([]),
            countInit : 0,
            currentDate : null,
            test:'mantap',
            selectedMonth: null,
            months: [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ]
        }
    },

    methods :{

        DataTablesFeatures() {
            var selectedMonth = this.getMonthName(this.selectedMonth);
            var currentDate=  this.currentDate;
            $(document).ready(function () {
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: 'Print',
                            title: '',
                            message: 
                            `<strong>Gofit</strong>
                            </br>
                            <p>Jl CentralPark No. 10 Yogyakarta</p>
                            </br>
                            <strong><u>Laporan Aktivitas Kelas Bulanan</u></strong>
                            </br>
                            <p><u>Bulan : ${selectedMonth} Tahun: 2023</u></p>
                            <p>Tanggal Cetak : ${currentDate} </p>
                            `
                        }
                    ]
                });
            });
        },


    
        async getDataKelasBulanan(message,bulan = null){
            const url = "/laporanaktivitaskelas";
            const params = (bulan != null) ? { month: bulan } : {};
            this.currentDate =  this.getCurrentDateTime();
            const request = await this.$http.get(url, {params : params})
            this.dataLaporan = request.data.data
            console.log('tanggal' , this.currentDate)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
        },

        getCurrentDateTime() {
            const now = new Date();
            const date = now.getDate();
            const month = now.getMonth() + 1; // Perhatikan penambahan 1 karena indeks bulan dimulai dari 0
            const year = now.getFullYear();
            // const hours = now.getHours();
            // const minutes = now.getMinutes();

            // Format tanggal
            const formattedDate = this.addLeadingZero(date) + "/" + this.addLeadingZero(month) + "/" + year;
            
            // Format waktu
            // const formattedTime = this.addLeadingZero(hours) + ":" + this.addLeadingZero(minutes);
            
            // Gabungkan tanggal dan waktu
            const dateTime = formattedDate ;
            
            return dateTime;
            },

            // Fungsi untuk menambahkan angka 0 di depan angka satu digit (0-9)
            addLeadingZero(number) {
            return (number < 10 ? "0" : "") + number;
            },

            getMonth(){
                const now = new Date();
                const month = now.getMonth() + 1; // Perhatikan penambahan 1 karena indeks bulan dimulai dari 0
                return month;
            },

            getMonthName(month) {
            const monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return monthNames[month - 1];
            }

    },
    async mounted(){
        this.selectedMonth = this.getMonth();
        await this.getDataKelasBulanan('Berhasil Mengambil Data Kelas Bulanan' ,this.selectedMonth );
        console.log(this.selectedMonth);
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Laporan Kelas Bulanan'"></home-navbar>
  </header>
  <main>
    <div class="container mt-5">
        <label for="bulan">Pilih Bulan:</label>
            <select id="bulan" v-model="selectedMonth">
                <option v-for="(bulan, index) in months" :key="index" :value="index+1">{{ bulan }}</option>
            </select>
        <button class="btn btn-primary m-2" @click="getDataKelasBulanan('Ambil Kembali Data',selectedMonth)">Ambil Data</button>
    </div>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi Gym</bu   tton> -->
      </div>
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div  class="container-fluid  p-4">
            <h3 >Tabel Laporan Kelas Bulanan</h3>
            <!-- <button class="btn btn-primary m-3" @click="cetakData">Cetak Laporan</button> -->
            <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Instruktur</th>
                        <th>Jumlah Peserta</th>
                        <th>Jumlah Libur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in dataLaporan" :key="key">
                        <td>{{row.kelas}}</td>
                        <td>{{row.instruktur}}</td>
                        <td>{{row.jumlah_peserta_kelas}}</td>
                        <td>{{ row.jumlah_libur }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <back-button class="col-md-3" className="btn btn-dark"></back-button>
                <!-- <button class="btn btn-success  col col-md-3">Cetak Struk</button> -->
            </div>
        </div>
  </div>
  </main>
</template>



<style scoped>
    .table-custom{
        border-radius: 10px;
    }


    .title.active {
  background-color: #e6e6e6;
}
  
.title:hover {
  background-color: #f2f2f2;
}

</style>
