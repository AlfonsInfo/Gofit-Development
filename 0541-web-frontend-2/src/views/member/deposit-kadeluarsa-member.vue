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
            members : ref([]),
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

        // async confirmPermit(id){
        //     const url = `/ijininstruktur/${id}`
        //     const request = await this.$http.put(url,{status_ijin : 'dikonfirmasi'});
        //     $toast.success('Berhasil Konfirmasi Ijin Instruktur')
        //     this.getAllPresence()
        //     console.log(request)
        // },
    
        async getAllMemberKadeluarsa(message){
            const url = "http://localhost:8000/api/depositkadeluarsa";
            const request = await this.$http.get(url)
            this.members = request.data.data
            console.log(this.members)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
        },
        async resetDeposit(message){
          const url = "http://localhost:8000/api/resetdeposit";
            const request = await this.$http.get(url)
            this.members = request.data.data
            console.log(this.members)
            if(this.countInit == 0)
            {
                this.DataTablesFeatures()
                this.countInit++;
                $toast.success(message)
            }
        }
},
    mounted(){
        this.getAllMemberKadeluarsa('Berhasil Mengambil Data Ijin Instruktur');
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - reset deposot Member'"></home-navbar>
  </header>
  <main>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <button class="btn btn-primary" @click="resetDeposit">Reset Deposit</button>
      </div> 
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div  class="container-fluid  p-4">
            <h3 >Member Kadeluarsa</h3>
            <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID Ijin</th>
                        <th>Nama Member</th>
                        <th>Tanggal Kadeluarsa Paket</th>
                        <th>Sisa Paket</th>
                        <!-- <th>Instruktur Pengganti</th> -->
                        <!-- <th>Status Ijin</th> -->
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in members" :key="key">
                        <td>{{row.id_member}}</td>
                        <td>{{row.nama_member}}</td>
                        <td>{{row.tgl_kadeluarsa_paket}}</td>
                        <td>{{row.total_deposit_paket}}</td>
                        <!-- <td>{{ row.id_instruktur }}</td> -->
                        <!-- <td>{{row.id_instruktur_pengganti}}</td> -->
                        <!-- <td>{{ (row.status_ijin)? row.status_ijin : 'belum dikonfirmasi' }}</td> -->
                        <td>
                            <!-- <button v-if="row.status_ijin == null" @click="confirmPresence(row.no_booking)" class="btn btn-success">Presensi</button> -->
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
