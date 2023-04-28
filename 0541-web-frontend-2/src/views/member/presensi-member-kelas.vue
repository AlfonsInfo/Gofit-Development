<script>
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
//   import ModalDetail from '../../components/ModalDetail.vue';
  import { ref} from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {$toast} from '../../plugins/notifHelper.js'


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

        async confirmPresence(id){
            const url = `/presensikelas/${id}`
            const request = await this.http.put(url,{status_kehadiran : 1});
            $toast.success('Berhasil Konfirmasi Presensi')
            this.getAllPresence()
            console.log(request)
        },
    
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
        TableView(){
            this.viewMode = !this.viewMode;
            this.getAllPresence
        }
},
    mounted(){
        this.getAllPresence('Berhasil Mengambil Data Presensi');
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
                                <div v-else @click.prevent="" class="btn btn-warning">Cetak Struk</div>
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
