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
            ijinInstruktur : ref([]),
            countInit : 0,
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

        async confirmPermit(id){
            const url = `/ijininstruktur/${id}`
            const request = await this.$http.put(url,{status_ijin : 'dikonfirmasi'});
            $toast.success('Berhasil Konfirmasi Ijin Instruktur')
            this.getAllPresence()
            console.log(request)
        },
    
        async getAllPermit(message){
            const url = "http://localhost:8000/api/ijininstruktur";
            const request = await this.$http.get(url)
            this.ijinInstruktur = request.data.data
            console.log(this.ijinInstruktur)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
            },
},
    mounted(){
        this.getAllPermit('Berhasil Mengambil Data Ijin Instruktur');
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
            <h3 >Tabel Data Ijin Instruktur</h3>
            <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID Ijin</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Jadwal Harian</th>
                        <th>Instruktur Ijin</th>
                        <th>Instruktur Pengganti</th>
                        <th>Status Ijin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in ijinInstruktur" :key="key">
                        <td>{{row.id_ijin}}</td>
                        <td>{{row.tanggal_pengajuan}}</td>
                        <td>{{row.id_jadwal_harian}}</td>
                        <td>{{ row.id_instruktur }}</td>
                        <td>{{row.id_instruktur_pengganti}}</td>
                        <td>{{ (row.status_ijin)? row.status_ijin : 'belum dikonfirmasi' }}</td>
                        <td>
                            <button v-if="row.status_ijin == null" @click="confirmPresence(row.no_booking)" class="btn btn-success">Presensi</button>
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
