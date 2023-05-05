<script>
import { HomeNavbar,BackButton,ref,defineComponent,useRouter,$toast,DataTables, Swal ,jsPDF} from '@/plugins/global';
export default defineComponent({
    //Component yang digunakan
    components:{
        HomeNavbar,
        BackButton
    },
    //Akhir dari Definisi Components yang digunakan
    
    //Awal dari Data
    data(){
        return{
            router : useRouter(),
            inActiveMember : ref([]),
            ActiveMember : ref([]),
            countInit : 0,
            NoStruk : '',
            Kadeluarsa : new Date(),
            selectedMember : ref([]),
            pegawaiPIC : '',
            tanggalTransaksi : new Date(),
            hasilTransaksi : ref({
                transaksi_aktivasi : {no_struk :''},
                transaksi_member :{},
            }),
        }
    },
    //Akhir dari Data


    //Awal Dari Methods
    methods :{

        async confirmTransaction(row)
        {
            this.generateTransactionData(row)            
            //Confirm
            const result = await Swal.fire({
            title: 'Apakah Anda yakin melakukan konfirmasi transaksi aktivasi ? ',
            html: `
                <p>Detail Transaksi :</p>
                <ul>
                <p>ID Member: ${row.id_member}</p>
                <p>Jumlah Transaksi: Rp 3.000.0000</p>
                <p>Tanggal Kadaluarsa: ${this.Kadeluarsa.getDate()} - ${this.Kadeluarsa.getMonth()+1} - ${this.Kadeluarsa.getFullYear()} </p>
                </ul>`,
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
            })
            if(result.isConfirmed){
                this.ActivationTransaction()
            }
        },


        async ActivationTransaction(){
            try{
                const data = {
                    id_pegawai : this.pegawaiPIC.id_pegawai,
                    id_member : this.selectedMember.id_member,
                };
                //Request transaksi-aktivasi
                const response = await this.$http.post('/transaksiaktivasi',data);
                //Jika berhasil update ExpiredMember
                this.updateExpiredMember(data)
                //Hasil Transaksi
                this.hasilTransaksi = response.data.data

                this.generateStrukAktivasi()

                $toast.success('Berhasil Konfirmasi Aktivasi')
                
                //Ambil kembali data member yang telah diupdate
                this.getAllMember()
                $toast.success(response.data.message);        
                Swal.fire({
                    title: 'Transaksi Berhasil!',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
                window.location.reload()
            }catch{
                $toast.warning('Transaksi Gagal, Cek Data Transaksi !!')
            }
        },


        formatDateStruk(){
            this.tanggalTransaksi = new Date(this.hasilTransaksi.transaksi_aktivasi.tanggal_aktivasi );
            this.hasilTransaksi.transaksi_aktivasi.tanggal_aktivasi = this.tanggalTransaksi.toLocaleString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) + " " + this.tanggalTransaksi.toLocaleTimeString("id-ID", {hour: '2-digit', minute:'2-digit'}).replace(".",":");
        },

        async generateTransactionData(row)
        {
            console.log(row)
            const today = new Date();
            this.selectedMember = row;
            if(row.tgl_kadeluarsa_aktivasi == null)
            {
                this.Kadeluarsa = new Date();
                this.Kadeluarsa.setFullYear(today.getFullYear() + 1) 
            }else{
                this.Kadeluarsa = new Date(row.tgl_kadeluarsa_aktivasi);
                this.Kadeluarsa.setFullYear(this.Kadeluarsa.getFullYear() + 1);
            }
        },
        
        // JSPDFF
        generateStrukAktivasi() {
            this.formatDateStruk();
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

        async updateExpiredMember({id_member})
        {
            try{
                const response = await this.$http.get(`/updatememberexpired/${id_member}`)
                console.log('response',response.data.tgl_kadaluarsa);
                this.Kadeluarsa = response.data.tgl_kadaluarsa;
                $toast.success(response.data.message);
                console.log(this.kadeluarsa)
            }catch(e){
                console.error('Error Update Data Member');
            }
        },

        
        //Getting Data
        //Get All Member
        async getAllMember(message){
            const request = await this.$http.get('/member');
            this.inActiveMember = request.data.data.filter(values => (values.tgl_kadeluarsa_aktivasi == null || values.tgl_kadeluarsa_aktivasi > Date()))
            this.ActiveMember = request.data.data.filter(values => (values.tgl_kadeluarsa_aktivasi != null || values.tgl_kadeluarsa_aktivasi < Date()))
            if(this.countInit == 0)
            {
                DataTables('#table-active-member',[0,1,2])
                DataTables('#table-inactive-member',[0,1,2])
                this.countInit++;
                $toast.success(message)
            }
        },

        //Get All Pegawai
        getDataPegawai()
        {
          let pegawai = localStorage.getItem('pegawaiData');
          return JSON.parse(pegawai)
        },  
},




    //Mounted
    mounted(){
        this.getAllMember('Berhasil Mengambil Data Presensi');
        this.pegawaiPIC = this.getDataPegawai()
    },
    //Akhir Dari Mounted

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
                            <button  type="button" class="btn btn-success" @click="confirmTransaction(row)" >Aktivasi</button>
                            <!-- <button @click="generateTransactionData(row)" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Aktivasi</button> -->
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
                            <button @click="confirmTransaction(row)"  type="button" class="btn btn-primary">
                            Perpanjang Aktivasi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <back-button class="col-md-3" className="btn btn-dark"></back-button>
            </div>
        </div>
        
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <p><strong> Nominal Transaksi : Rp </strong>  3.000.000</p>
                    <p><strong> ID Member :  </strong>      {{ selectedMember.id_member }}/{{ selectedMember.nama_member }}</p>
                    <!-- <p><strong> Kadeluarsa :  </strong>  {{  Kadeluarsa }}</p> -->
                    <!-- <p><strong> Kadeluarsa :  </strong>  {{ ` ${Kadeluarsa.getDate()} - ${Kadeluarsa.getMonth()+1} - ${Kadeluarsa.getFullYear()}  ` }}</p> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="confirmTransaction(selectedMember)">Konfirmasi Transaksi</button>
                </div>
                </div>
            </div>
            
        </div>
  </div>
  <div>
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
                        <td>No Struk : {{ hasilTransaksi.transaksi_aktivasi.no_struk }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tanggal : {{ hasilTransaksi.transaksi_aktivasi.tanggal_aktivasi }}</td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.transaksi_member.id_member }}</td>
                                </tr>
                                <tr>
                                    <td >Aktivasi Tahunan</td>
                                    <td>:</td>
                                    <td>Rp.3.000.0000,-</td>
                                </tr>
                                <tr>
                                    <td>Masa Aktif Member</td>
                                    <td>:</td>
                                    <td>{{ ` ${Kadeluarsa.getDate()}/${Kadeluarsa.getMonth()+1}/${Kadeluarsa.getFullYear()}` }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kasir : {{pegawaiPIC.id_pegawai}}/{{ pegawaiPIC.nama_pegawai }} </td>
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

.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1030;    
}

.test{
    height: 200px;
    width: 1000px;
}

#pdfContent{
    margin-right: 10px;
}


#pdfContent p {
  margin: 0;
}
@media print {
  /* Menampilkan elemen yang di-hidden saat dicetak */
  #pdfContent {
    display: block !important;
  }
}

</style>
