<script>
import { HomeNavbar, useRouter, ref ,  $toast, defineComponent, BackButton, Swal, jsPDF } from '@/plugins/global.js'


  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },
    
    data(){
        return{
            router : useRouter(),
            Presensikelas : ref([]),
            countInit : 0,
            viewMode : true,
            selectedPresensi : '',
            pegawaiPIC : '',
            hasilTransaksi : ref({
                data : {no_struk :'', 

            },
            jadwal_harian : { jadwal_umum : {
                kelas : {},
                instruktur  : {}
            }}, 
            member : {
                nama_member : '',
            }
            }),
            transaksiData : ref({
                jenis_transaksi : ''
            }),
            currentDate : '',
        }
    },

    methods :{

        //* Data table jquery
        DataTablesFeatures()
        {
            $(document).ready(function () {
    // Setup - add a text input to each footer cell
            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');
        
                var table = $('#example').DataTable({
                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {
                        var api = this.api();
            
                        // For each column
                        api
                            .columns([0,1,2,3,4])
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters th').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                $(cell).html('<input type="text" placeholder="' + title + '" />');
            
                                // On every keypress in this input
                                $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('keyup change')
                                    .on('change', function (e) {
                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();
            
                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();
                                    })
                                    .on('keyup', function (e) {
                                        e.stopPropagation();
            
                                        $(this).trigger('change');
                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });
                            });
                    },
                });
            });
        },

        //* Konfirmasi Presensi
        async confirmPresence(id){
            const url = `/presensikelas/${id}`
            const request = await this.$http.put(url,{status_kehadiran : 1});
            $toast.success('Berhasil Konfirmasi Presensi')
            this.getAllPresence()
            console.log(request)
        },
        
        //* Show Data Presensi
        async getAllPresence(message){
            const url = "/presensikelas";
            const request = await this.$http.get(url)
            this.Presensikelas = request.data.data
            console.log(this.Presensikelas)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
        },
        //View mode Card View
        TableView(){
            this.viewMode = !this.viewMode;
            this.getAllPresence
        },
        

        //* Dijalankan saat tombol cetak struk dipencet
        async getNoStruk(row){
            this.selectedPresensi = row;
            const result = await Swal.fire({
            title: 'Apakah Anda yakin melakukan Cetak Struk ? ',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
            })
            if(result.isConfirmed){

            const url = `/cetakstrukkelas/${row.no_booking}`
            const request = await this.$http.post(url,{id_pegawai : this.pegawaiPIC.id_pegawai});
            this.hasilTransaksi = request.data.data
            this.transaksiData = request.data.transaksi
            // console.log('sama ga', this.jenis_transaksi.jenis_transaksi == 'transaksi-presensi-kelas-paket');
            // console.log('hasil', this.hasilTransaksi);
            // console.log(this.hasilTransaksi.jadwal_harian.jadwal_umum.kelas.jenis_kelas);
            this.generateStrukAktivasi();
            this.getAllPresence()
            this.currentDate = this.getCurrentDateTime()
            console.log(request)

            Swal.fire({
                    title: 'Presensi Berhasil!',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        },


        generateStrukAktivasi() {
            window.jspPDF = window.jspdf.jsPDF;
            var elementHTML = document.querySelector('#pdfContent');
            elementHTML.style.display = "block";
            elementHTML.style.fontSize = '5px';
            //Spasi
            elementHTML.style.lineHeight = '1.2'; 
            elementHTML.style.margin = '0';
            elementHTML.style.padding = '0';

            let doc = new jsPDF({
                orientation: 'l', // orientasi landscape
                unit: 'mm', // satuan millimeter
                format: ['500','200'], // ukuran kertas A4
            });

            doc.html(elementHTML, {
            callback: function (doc) {
                doc.save('file.pdf');
                elementHTML.style.display = "none";
            },
            x: 10,
            y: 10
            });
        },

        

        getCurrentDateTime() {
            var now = new Date();
            var date = now.getDate();
            var month = now.getMonth() + 1; // Perhatikan penambahan 1 karena indeks bulan dimulai dari 0
            var year = now.getFullYear();
            var hours = now.getHours();
            var minutes = now.getMinutes();

            // Format tanggal
            var formattedDate = this.addLeadingZero(date) + "/" + this.addLeadingZero(month) + "/" + year;
            
            // Format waktu
            var formattedTime = this.addLeadingZero(hours) + ":" + this.addLeadingZero(minutes);
            
            // Gabungkan tanggal dan waktu
            var dateTime = formattedDate + " " + formattedTime;
            
            return dateTime;
            },

        // Fungsi untuk menambahkan angka 0 di depan angka satu digit (0-9)
        addLeadingZero(number) {
        return (number < 10 ? "0" : "") + number;
        },


        getDataPegawai()
        {
          let pegawai = localStorage.getItem('pegawaiData');
          return JSON.parse(pegawai)
        },



},
    mounted(){
        this.getAllPresence('Berhasil Mengambil Data Presensi');
        this.pegawaiPIC = this.getDataPegawai();
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Olah Presensi Kelas'"></home-navbar>
  </header>
  <main>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi kelas</bu   tton> -->
        <div>
            <button class="btn btn-success mb-3" v-if="viewMode" @click="viewMode = !viewMode">Card View</button>
            <button class="btn btn-success mb-3" v-else @click="TableView">Table View</button>
        </div>
      </div>
      <div v-if="viewMode" class="content bg-white text-dark table-custom m-5 mt-2">
        <div class="container-fluid  p-4">
            <div class="d-flex justify-content-between">
                <h3 >Data Keseluruhan Presensi Kelas</h3>
            </div>
            <table id="example" class="#example table table-striped filters" style="width:100%;" >
                <thead>
                    <tr>
                        <th>Tanggal Booking</th>
                        <th>ID Member</th>
                        <th>Jadwal</th>
                        <th>Status Kehadiran</th>
                        <th>No Struk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in Presensikelas" :key="key">
                        <td>{{row.tanggal_booking}}</td>
                        <td>{{ row.id_member }}</td>
                        <td><button class="btn btn-primary">Detail {{row.jadwal_harian.tanggal_jadwal_harian}}</button></td>
                        <td>{{(row.status_kehadiran == 0) ? 'Belum Hadir' : 'Telah Dikonfirmasi'}}</td>
                        <td>
                            <div v-if="row.no_struk">{{ row.no_struk }}</div>
                            <div v-else>
                                <div v-if="row.status_kehadiran == 0">Belum Cetak Struk</div>
                                <div v-else @click.prevent="getNoStruk(row)" class="btn btn-warning">Cetak Struk</div>
                            </div>
                        </td>
                        <td>
                            <button v-if="row.status_kehadiran == 0" @click="confirmPresence(row.no_booking)" class="btn btn-success">Presensi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <back-button class="col-md-3" className="btn btn-dark"></back-button>
                <!-- <button class="btn btn-success  col col-md-3">Cetak Struk</button> -->
            </div>
        </div>
    </div>
    <div class="content bg-white text-dark table-custom m-5 mt-2" v-else>
        Ambil tabel jadwal harian dari sesudah hari ini
    </div>
  </main>

  
<!-- Ini Awal Struk -->
<div class="bg light" >
        <!-- <button @click="generateStrukAktivasi">Cetak Struk</button> -->
        <div  width="600px" id="pdfContent" style=" display: none; margin:500px;" class=" text-dark">
            <div width="600px" class="p-1 ">
                <table class="border border-dark">
                    <tr>
                        <td style="width: 70%;"><strong>Gofit</strong>
                        <p>Jl Centralpark No 10 Yogyakarta</p></td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td v-if="transaksiData.jenis_transaksi == 'transaksi-presensi-kelas'"><strong>STRUK PRESENSI KELAS</strong></td>
                                    <td v-if="transaksiData.jenis_transaksi == 'transaksi-presensi-kelas-paket'"><strong>STRUK PRESENSI KELAS PAKET</strong></td>
                                    </tr>
                                <tr>
                                    <td >No Struk</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.no_struk }}</td>
                                </tr>
                                <tr>
                                    <td >Tanggal</td>
                                    <td>:</td>
                                    <td>{{currentDate}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>                    
                    <tr>
                        <td>
                            <table v-if="transaksiData.jenis_transaksi == 'transaksi-presensi-kelas-paket'">
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ selectedPresensi.id_member }} / {{ hasilTransaksi.member.nama_member }}</td> 
                                    <!-- //{{ hasilTransaksi.member.nama_member }} -->
                                </tr>
                                <tr>
                                    <td >Kelas</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.jadwal_harian.jadwal_umum.kelas.jenis_kelas }}</td>
                                </tr>
                                <tr>
                                    <td >Instruktur</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.jadwal_harian.jadwal_umum.instruktur.nama_instruktur }}</td>
                                </tr>
                                <tr>
                                    <td >Sisa Deposit</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.member.total_deposit_paket }} </td>
                                </tr>
                                <tr>
                                    <td >Berlaku sampai dengan</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.member.tgl_kadeluarsa_paket }} </td>
                                </tr>
                            </table>
                            <table v-else>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ selectedPresensi.id_member }} / {{ hasilTransaksi.member.nama_member }}</td> 
                                    <!-- //{{ hasilTransaksi.member.nama_member }} -->
                                </tr>
                                <tr>
                                    <td >Kelas</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.jadwal_harian.jadwal_umum.kelas.jenis_kelas }}</td>
                                </tr>
                                <tr>
                                    <td >Instruktur</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.jadwal_harian.jadwal_umum.instruktur.nama_instruktur }}</td>
                                </tr>
                                <tr>
                                    <td >Tarif</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.jadwal_harian.jadwal_umum.kelas.harga_kelas }}</td>
                                </tr>
                                <tr>
                                    <td >Sisa deposit</td>
                                    <td>:</td>
                                    <td>{{ parseInt(hasilTransaksi.member.total_deposit_uang)  - parseInt(  hasilTransaksi.jadwal_harian.jadwal_umum.kelas.harga_kelas) }} </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                            <td></td>
                            <!-- <td>Kasir : {{pegawaiPIC.id_pegawai}}/{{ pegawaiPIC.nama_pegawai }} </td> -->
                        </tr>
                        
                    </table>
            </div>
        </div>
    </div>
<!-- Ini Akhir Struk -->
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
