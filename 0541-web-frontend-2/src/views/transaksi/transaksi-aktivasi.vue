<script>
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
//   import ModalDetail from '../../components/ModalDetail.vue';
  import { ref} from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {$toast} from '../../plugins/notifHelper.js'
  import {DataTables} from '../../plugins/TableHelper.js'


  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },
    
    data(){
        return{
            router : useRouter(),
            inActiveMember : ref([]),
            ActiveMember : ref([]),
            countInit : 0,
            showTable : true, // true Stand for Presensi Member Gym
            NoStruk : '',
            Kadeluarsa : new Date(),
            selectedMember : ref([]),
            pegawaiPIC : '',
        }
    },

    methods :{

        async generateTransactionData(row)
        {
            const request = await this.$http.get('/transaksiaktivasi');
            const nextNoStruk = request.data + 1;
            const today = new Date();
            const year = today.getFullYear().toString().substr(-2); // Mengambil 2 digit terakhir dari tahun
            const month = ('0' + (today.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan kurang dari 10
            this.NoStruk =  year + '.' + month + '.' + nextNoStruk;
            
            this.selectedMember = row;
            if(row.tgl_kadeluarsa_aktivasi == null)
            {
                this.Kadeluarsa = new Date();
                this.Kadeluarsa.setFullYear(today.getFullYear() + 1) 
            }else{
                // Convert the date string to a Date object
                this.Kadeluarsa = new Date(row.tgl_kadeluarsa_aktivasi);

                // Add one year to the date
                this.Kadeluarsa.setFullYear(this.Kadeluarsa.getFullYear() + 1);
                }
        },
        
        generateStrukAktivasi()
        {
            console.log('ini struk aktivasi')
        },

        async confirmTransaction(){
            try{
                console.log(this.selectedMember)
                const data = {
                    id_pegawai : this.pegawaiPIC.id_pegawai,
                    id_member : this.selectedMember.id_member,
                }
                const request = await this.$http.post('/transaksiaktivasi',data);
                //Selanjutnya update table member kolom kadeluarsa aktivasi
                this.generateStrukAktivasi()
                $toast.success('Berhasil Konfirmasi Presensi')
                this.getAllMember()
            }catch{
                $toast.warning('Gagal Melakukan Transaksi')
            }
        },
        
    
        async getAllMember(message){
            const request = await this.$http.get('/member');
            this.inActiveMember = request.data.data.filter(values => (values.tgl_kadeluarsa_aktivasi == null || values.tgl_kadeluarsa_aktivasi > Date()))
            this.ActiveMember = request.data.data.filter(values => (values.tgl_kadeluarsa_aktivasi != null || values.tgl_kadeluarsa_aktivasi < Date()))
            console.log(this.ActiveMember)
            console.log(this.inActiveMember)
            if(this.countInit == 0)
            {
                DataTables('#table-active-member',[0,1,2])
                DataTables('#table-inactive-member',[0,1,2])
                this.countInit++;
                $toast.success(message)
            }
        },
        getDataPegawai()
        {
          let pegawai = localStorage.getItem('pegawaiData');
          return JSON.parse(pegawai)
        },  
},
    mounted(){
        this.getAllMember('Berhasil Mengambil Data Presensi');
        this.pegawaiPIC = this.getDataPegawai()
        console.log(this.pegawaiPIC)
    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Menu Transaksi Aktivasi'"></home-navbar>
  </header>
  <main>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi Gym</bu   tton> -->
      </div>
      <div class="content bg-white text-dark table-custom m-5 mt-2">
        <div  class="container-fluid  p-4">
            <h3 >Tabel Member Tidak Aktif</h3>
            <table id="table-inactive-member" class="#example table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID Member</th>
                        <th>Nama Member</th>
                        <th>No Telp Member</th>
                        <th>Tanggal Kadeluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in inActiveMember" :key="key">
                        <td>{{row.id_member}}</td>
                        <td>{{row.nama_member}}</td>
                        <td>{{row.no_telp_member}}</td>
                        <td>{{ (row.tgl_kadeluarsa_aktivasi) ? row.tgl_kadeluarsa_aktivasi : 'Belum Pernah Aktivasi' }}</td>
                        <td>
                            <button @click="generateTransactionData(row)" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Aktivasi</button>
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
            <h3 >Tabel Member Aktif</h3>
            <table id="table-active-member" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID Member</th>
                        <th>Nama Member</th>
                        <th>Tanggal Kadeluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in ActiveMember" :key="key">
                        <td>{{row.id_member}}</td>
                        <td>{{row.nama_member}}</td>
                        <td>{{ (row.tgl_kadeluarsa_aktivasi) ? row.tgl_kadeluarsa_aktivasi : 'Belum Pernah Aktivasi' }}</td>
                        <td>
                            <button @click="generateTransactionData(row)"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Perpanjang Aktivasi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <back-button class="col-md-3" className="btn btn-dark"></back-button>
                <!-- <button class="btn btn-success  col col-md-3">Cetak Struk</button> -->
            </div>
        </div>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Aktivasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>No Struk : {{ NoStruk }}</h2>
                <hr>
                <p><strong> Transaksi : </strong> transaksi-aktivasi</p>
                <p><strong> Nominal Transaksi : </strong>  300.000</p>
                <p><strong> ID Member :  </strong>      {{ selectedMember.id_member }}</p>
                <p><strong> Kadeluarsa :  </strong>  {{  Kadeluarsa }}</p>
                <p><strong> Kadeluarsa :  </strong>  {{ ` ${Kadeluarsa.getDate()} - ${Kadeluarsa.getMonth()+1} - ${Kadeluarsa.getFullYear()}  ` }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="confirmTransaction(selectedMember)">Konfirmasi Transaksi</button>
            </div>
            </div>
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
