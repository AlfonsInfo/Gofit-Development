<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
  import ModalDetail from '../../components/ModalDetail.vue';
  import { ref, reactive, computed} from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {  ActionRouteToCreate, ActionViewDetail,ActionUpdate,ActionDelete} from '../../data/actionData'
  import {$toast} from '../../plugins/notifHelper.js'



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
            showTable : true // true Stand for Presensi Member Gym
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
            const url = `http://localhost:8000/api/presensigym/${id}`
            const request = await axios.put(url,{status_kehadiran : 1});
            $toast.success('Berhasil Konfirmasi Presensi')
            this.getAllPresence()
            console.log(request)
        },
    
        async getAllPresence(message){
            const url = "http://localhost:8000/api/presensigym";
            const request = await axios.get(url)
            this.Presensigym = request.data.data
            console.log(this.Presensigym)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
            },
},
    mounted(){
        this.getAllPresence('Berhasil Mengambil Data Presensi');
    },
    computed : {
        displayedData(){
            if(this.showTable == true)
            {
                // <th>Tanggal Booking</th>
                //         <th>Tanggal Sesi Gym</th>
                //         <th>Status Kehadiran</th>
                //         <th>ID Member</th>
                //         <th>No Struk</th>
                //         <th>Aksi</th>
                return{
                    'presensi' : this.Presensigym,
                    'column' : ['Tanggal Booking','Tanggal Sesi Gym','Status Kehadiran','ID Member', 'No Struk', 'Aksi'],
                } 
            }else{
                return{
                    'presensi' :  this.PresensiKelas,
                    'column' : 'test'
                }
            }
        }


    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Olah Presensi Gym Member'"></home-navbar>
  </header>
  <main>
    <div class="content bg-white text-dark table-custom m-5">
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
                    <tr v-for="(row,key) in displayedData.presensi" :key="key">
                        <td>{{row.tanggal_booking}}</td>
                        <td>{{row.tanggal_sesi_gym}}</td>
                        <td>{{(row.status_kehadiran == 0) ? 'Belum Hadir' : 'Telah Dikonfirmasi'}}</td>
                        <td>{{ row.id_member }}</td>
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
        <div v-else class="container-fluid  p-4">
            <h3>Tabel Presensi Member Kelas</h3>
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
                        <td>{{(row.status_kehadiran == 0) ? 'Belum Hadir' : 'Telah Dikonfirmasi'}}</td>
                        <td>{{ row.id_member }}</td>
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
