<script>
import { HomeNavbar, useRouter,  $toast, defineComponent, BackButton ,ref } from '@/plugins/global.js'
import { customSwal } from '../../plugins/function';



  export default defineComponent({  
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },
    
    data(){
        return{
            router : useRouter(),
            ijininstrukturforconfirm : ref([]),
            ijinInstruktur : ref([]),
            countInit : 0,
            countInit2 : 0,
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
                  "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "10%", "targets": 2 }
                ],
                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {
                        var api = this.api();

                        // For each column
                        api
                            .columns([0,1,2,3])
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
        TableAll()
        {
            $(document).ready(function () {
    // Setup - add a text input to each footer cell
            $('#example2 thead tr')
                .clone(true)
                .addClass('filters')
                // .appendTo('#example2 thead');
        
                var table = $('#example2').DataTable({
                  "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "10%", "targets": 2 }
                ],
                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {

                    },
                });
            });
        },

        confirm(id){
            customSwal('Yakin ingin mengijinkan instruktur ? ', 'question','blue','Yakin',this.confirmPermit,id)
        },

        deny(id){
            customSwal('Yakin ingin menolak perijinan instruktur ? ', 'question','blue','Yakin',this.denyPermit,id)
        },

        async confirmPermit(id){
            console.log(id);
            const url = `/ijininstruktur/${id}`
            const request = await this.$http.put(url,{status_ijin : 'Perijinan dikonfirmasi'});
            $toast.success('Berhasil Konfirmasi Ijin Instruktur')
            this.getBeforeConfirm()
            console.log(request)
        },
        async denyPermit(id){
            console.log(id);
            const url = `/ijininstruktur/${id}`
            const request = await this.$http.put(url,{status_ijin : 'Perijinan ditolak'});
            $toast.success('Berhasil Konfirmasi Ijin Instruktur')
            this.getBeforeConfirm()
            console.log(request)
        },
    
        async getBeforeConfirm(message){
            const url = "http://localhost:8000/api/ijininstrukturforconfirm";
            const request = await this.$http.get(url)
            this.ijininstrukturforconfirm = request.data.data
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
            },

        async getAllPermit(){
            const url = "http://localhost:8000/api/ijininstruktur";
            const request = await this.$http.get(url)
            this.ijinInstruktur = request.data.data
            if(this.countInit2 == 0)
            {
                this.TableAll()
                this.countInit2++;
            }
        }
},
    mounted(){
        this.getBeforeConfirm('Berhasil Mengambil Data Ijin Instruktur');
        this.getAllPermit()
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Olah Ijin Instruktur'"></home-navbar>
  </header>
  <main>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi Gym</bu   tton> -->
      </div>
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div  class="container-fluid  p-4">
            <h3 >Tabel Data Ijin Instruktur Belum Dikonfirmasi</h3>
            <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <!-- <th>ID Ijin</th> -->
                        <th>Tanggal Pengajuan</th>
                        <th>Jadwal Harian</th>
                        <th>Instruktur Ijin</th>
                        <th>Instruktur Pengganti</th>
                        <th>Status Ijin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in ijininstrukturforconfirm" :key="key">
                        <!-- <td>{{row.id_ijin}}</td> -->
                        <td>{{row.tanggal_pengajuan}}</td>
                        <td>{{row.jadwal_harian.tanggal_jadwal_harian}}</td>
                        <td>{{ row.instruktur.nama_instruktur }}</td>
                        <td>{{row.instruktur_pengganti.nama_instruktur}}</td>
                        <td>{{ row.status_ijin  }}</td>
                        <td>
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirmPermit(row.id_ijin)" class="btn btn-success mx-2">👍</button> -->
                            <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirm(row.id_ijin)" class="btn btn-success mx-2">👍</button>
                            <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="deny(row.id_ijin)" class="btn btn-danger">🙅‍♂️</button>
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirmPermit(row.id_ijin)" class="btn btn-danger">🙅‍♂️</button> -->
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
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div  class="container-fluid  p-4">
            <h3 >Tabel Data Ijin</h3>
            <table id="example2" class="#example2 table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <!-- <th>ID Ijin</th> -->
                        <th>Tanggal Pengajuan</th>
                        <th>Jadwal Harian</th>
                        <th>Instruktur Ijin</th>
                        <th>Instruktur Pengganti</th>
                        <th>Status Ijin</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in ijinInstruktur" :key="key">
                        <!-- <td>{{row.id_ijin}}</td> -->
                        <td>{{row.tanggal_pengajuan}}</td>
                        <td>{{row.jadwal_harian.tanggal_jadwal_harian}}</td>
                        <td>{{ row.instruktur.nama_instruktur }}</td>
                        <td>{{row.instruktur_pengganti.nama_instruktur}}</td>
                        <td>{{ row.status_ijin  }}</td>
                        <!-- <td> -->
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirmPermit(row.id_ijin)" class="btn btn-success mx-2">👍</button> -->
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirm(row.id_ijin)" class="btn btn-success mx-2">👍</button> -->
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="deny(row.id_ijin)" class="btn btn-danger">🙅‍♂️</button> -->
                            <!-- <button v-if="row.status_ijin == 'Belum dikonfirmasi'" @click="confirmPermit(row.id_ijin)" class="btn btn-danger">🙅‍♂️</button> -->
                        <!-- </td> -->
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
