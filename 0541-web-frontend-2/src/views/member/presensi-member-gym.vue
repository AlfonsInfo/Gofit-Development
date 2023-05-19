<script>
import { HomeNavbar, useRouter, ref ,  $toast, defineComponent, BackButton ,Swal, jsPDF} from '@/plugins/global.js'



  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
      // TableData,
    //   ModalDetail
    },
    
    data(){
        return{
            router : useRouter(),
            Presensigym : ref([]),
            countInit : 0,
            showTable : true, // true Stand for Presensi Member Gym
            pegawaiPIC : '',
            selectedPresensi : {},
            hasilTransaksi : ref({
                data : {no_struk :'', 
            },
            sesi : {
                waktu_mulai : '', 
                waktu_selesai: ''},
                // transaksi_member :{},
            member : {
                nama_member : '',
            }
            }),
            currentDate : '',
            newMember : ref({})

        }
    },

    methods :{

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

        getDataPegawai()
        {
          let pegawai = localStorage.getItem('pegawaiData');
          return JSON.parse(pegawai)
        },

        async confirmPresence(id){
            //*Command
            const result = await Swal.fire({
            title: 'Apakah Anda yakin melakukan konfirmasi kehadiran ? ',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
            })
            if(result.isConfirmed){

            const url = `http://localhost:8000/api/presensigym/${id}`
            const request = await this.$http.put(url,{status_kehadiran : 1});
            $toast.success('Berhasil Konfirmasi Presensi')
            this.getAllPresence()
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

            const url = `/cetakstrukgym/${row.no_booking}`
            const request = await this.$http.post(url,{id_pegawai : this.pegawaiPIC.id_pegawai});
            this.hasilTransaksi = request.data.data
            console.log('hasil', this.hasilTransaksi);
            this.requestNewestMember(row.id_member);
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
    
        async getAllPresence(message){
            const url = "http://localhost:8000/api/presensigym";
            const request = await this.$http.get(url)
            this.Presensigym = request.data.data
            console.log(this.Presensigym)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
            },


            // JSPDFF
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
                format: ['300','100'], // ukuran kertas A4
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


    async requestNewestMember(id_member){
        console.log(id_member);
        const url = `/member/${id_member}`;
        const response = await this.$http.get(url);
        this.newMember = response.data.data[0];
        console.log(this.newMember);
    }
},
    mounted(){
        this.getAllPresence('Berhasil Mengambil Data Presensi');
        this.pegawaiPIC = this.getDataPegawai()
        // console.log(this.pegawaiPIC);
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Olah Presensi Gym Member'"></home-navbar>
  </header>
  <main>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi Gym</bu   tton> -->
      </div>
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div v-if="showTable" class="container-fluid  p-4">
            <h3 >Tabel Presensi member Gym</h3>
            <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>Tanggal Booking</th>
                        <th>Tanggal Sesi Gym</th>
                        <th>Status Kehadiran</th>
                        <th>ID Member</th>
                        <th>No Struk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in Presensigym" :key="key">
                        <td>{{row.tanggal_booking}}</td>
                        <td>{{row.tanggal_sesi_gym}}</td>
                        <!-- <td>{{(row.status_kehadiran == 0) ? 'Belum Hadir' : 'Telah Dikonfirmasi'}}</td> -->
                        <td>
                            <!-- <div v-if="row.status_kehadiran == null">Belum hadir</div> -->
                            <div v-if="row.status_kehadiran == 0">Tidak Hadir</div>
                            <div v-if="row.status_kehadiran == 1">Hadir</div>
                        </td>
                        <td>{{ row.id_member }}</td>
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
                                    <td><strong>STRUK PRESENSI GYM</strong></td>
                                    <!-- <td>:</td> -->
                                    <!-- <td>{{ hasilTransaksi.transaksi_member.id_member }}</td> -->
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
                    </tr>                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ selectedPresensi.id_member }} / {{ hasilTransaksi.member.nama_member }}</td> 
                                    <!-- //{{ hasilTransaksi.member.nama_member }} -->
                                </tr>
                                <tr>
                                    <td >Slot Waktu</td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.sesi.waktu_mulai }} - {{ hasilTransaksi.sesi.waktu_selesai }}</td>
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
