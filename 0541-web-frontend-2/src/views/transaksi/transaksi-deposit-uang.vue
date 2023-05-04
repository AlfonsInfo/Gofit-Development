<script>
import { HomeNavbar,defineComponent,$toast, Swal ,jsPDF, ref} from '@/plugins/global';

export default defineComponent({
  //Component
  components : {
      HomeNavbar,
    },

  data(){
    return{
      FormTransactionUang : {
        id_pegawai : this.getDataPegawai().id_pegawai,
        id_member : '',
        NoStruk : '',
        nominal_deposit : 0,
        id_promo : '',
      },

      //Array of Object
      promos : null,
      allMember : null,
      PromoMessage : 'Dapatkan Promo Menarik!!!',
      selectedPromo : null,
      member : ref({}),
      hasilTransaksi : ref({
                transaksi_deposit_reguler : {no_struk :''},
                transaksi_member :{},
            }),
      newMember : null,
    }
  },

  methods : {

  //Submit Form
  async submitForm()
  {
  //Confirm
  const result = await Swal.fire({
    title: 'Apakah Anda yakin ingin melakukan transaksi ini?',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal',
      })
      if(result.isConfirmed){
        this.depositMoneyTransaction()
      }
    },

    async depositMoneyTransaction(){
      try{
          this.getMember(this.FormTransactionUang)
          const url = '/transaksideposituang';
          const response = await this.$http.post(url,this.FormTransactionUang);
          this.hasilTransaksi = response.data.data  
          //Untuk Data Saldo Total
          this.requestNewestMember(this.FormTransactionUang.id_member);
          //Tampung hasil transaksi
          console.log(this.newMember);
          this.generateStrukDepositUang()
          // this.updateDepositBalance(response.data.total) Incase trigger tidak digunakan
          $toast.success(response.data.message);        
          Swal.fire({
            title: 'Transaksi Berhasil!',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
          })

        }catch{
          $toast.warning('Transaksi Gagal, Cek Data Transaksi !!')
        }
    },
    
    async updateDepositBalance(data){
      try{
        const url = `/updatedepositbalanceuang/${this.FormTransactionUang.id_member}`;
        const response = await this.$http.put(url,{total_deposit : data });
        $toast.success(response.data.message);
      }catch{
        $toast.warning('gagal update')
      }
    },

    //Generate Next No Struk
    async generateTransactionData()
    {
      const request = await this.$http.get('/transaksiaktivasi');
      const nextNoStruk = request.data + 1
      const today = new Date();
      const year = today.getFullYear().toString().substr(-2); // Mengambil 2 digit terakhir dari tahun
      const month = ('0' + (today.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan kurang dari 10
      this.FormTransactionUang.NoStruk =  year + '.' + month + '.' + nextNoStruk;
    },

    //PDFFF
    generateStrukDepositUang() {
            window.jspPDF = window.jspdf.jsPDF;
            var elementHTML = document.querySelector('#pdfContent2');
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


    //Generate Promo
    async getPromo(){
      const request = await this.$http.get('/promo');
      this.promos =  request.data.promo
    },
      

    //Select Promo Otomatis
    updateSelectedPromo() {
      //Promo yang bisa didapatkan
      let promo = this.availablePromo();
        
      //Promo lain yang bisa didapatkan jika menambah tSransakasi dengan jumlah tertentu
      let nearestPromo = this.nearestPromo();
      let [lackOfTranscaction, {nama_promo = '-'  , bonus_promo  = '-' }] = nearestPromo;

      //Clear toast
      $toast.clear( )

      //Set Form Promo
      if (promo && promo.id_promo != null) {
        this.FormTransactionUang.id_promo = promo.id_promo;
      }else{
        this.FormTransactionUang.id_promo = 0 ;
      }
      
      //Set PromoMessage & Toast Berdasarkan Kondisi Kekurangan Transaksi
      if (lackOfTranscaction != Infinity) {
        this.PromoMessage = `Transaksi kurang ${lackOfTranscaction} untuk mendapatkan promo ${nama_promo || 'yang tersedia'} dengan bonus deposit ${bonus_promo}!!!`
        $toast.info(`Tambah ${lackOfTranscaction} untuk mendapatkan bonus ${bonus_promo}`, {queue: true, duration:2000});
      }
      if (lackOfTranscaction == Infinity) {
        this.PromoMessage = `Selamat Anda berhasil Mendapatkan promo Menarik!!`
        $toast.success(`Selamat Anda, Berhasil mendapatkan promo paling menarik!!`, {queue: true, duration:2000});
      }
    },


    //Get Data Pegawai Yang Login dan Bertangggung jawab
    getDataPegawai()
    {
      let pegawai = localStorage.getItem('pegawaiData');
      return JSON.parse(pegawai)
    },

    //Dapatkan data promo yang cocok
    availablePromo() {
      let data = this.promos;
      let promo = null;
      data = data.filter((dt) => dt.jenis_promo === 'promo_reguler');
      data.forEach((value) => {
        if (value.minimal_deposit <= this.FormTransactionUang.nominal_deposit && (promo === null || value.minimal_deposit > promo.minimal_deposit)) {
          promo = value;
        }
      });
      return promo;
    },

    //Dapatkan promo yang nilainya dekat
    nearestPromo() {
      let data = this.promos;
      let promo = null;
      let differenceFromPromo = null;
      let finalNearestPromo = Infinity;
      data = data.filter((dt) => dt.jenis_promo === 'promo_reguler');
      data.forEach((value) => {
        differenceFromPromo = value.minimal_deposit - this.FormTransactionUang.nominal_deposit;
        if (differenceFromPromo > 0 && finalNearestPromo > differenceFromPromo) {
          finalNearestPromo = differenceFromPromo;
          promo = value;
        }
      });
      if(promo != null){
        return [finalNearestPromo,promo];
      }
      return [finalNearestPromo,{nama_promo : '-', bonus_promo : '-'} ];
    },  

      async getAllMember(){
        const dataRoute = "/member";
        const response = await this.$http.get(dataRoute)
        this.allMember = response.data.data
        console.log(this.allMember)
      },


      getMember({id_member}){
        this.member =  this.allMember.filter((item)=> { return item.id_member == id_member})[0];
      },

      async requestNewestMember(id_member){
        console.log(id_member);
        const url = `/member/${id_member}`;
        const response = await this.$http.get(url);
        this.newMember = response.data.data[0];
      }



    },
    mounted(){
      this.generateTransactionData();
      this.getPromo();
      this.getAllMember();
      this.requestNewestMember('23.04.010');
    }
})

</script>

<template >
    <header>
      <home-navbar :message="'Gofit - Transaksi Deposit Uang'"></home-navbar>
    </header>
    <main>
      <div class='content text-white p-5 mt-5'>
        <h2></h2>
        <div  class= 'container-fluid form-custom p-4 text-dark' ref="sectionForm">
          <div class="d-flex justify-content-between" >
            <h3 class="title">Transaksi Deposit Uang<span class="mdi mdi-cash-multiple ms-2"></span></h3>
          </div>
          <hr>
          <form @submit.prevent="submitForm($event)">
            <!-- No Struk -->
            <div class="mb-3">
              <label for="no-transaksi" class="form-label">No Struk</label>
                <input type="text" v-model="FormTransactionUang.NoStruk" class="form-control" id="no-transaksi" disabled>
            </div>
            <div class="mb-3">
              <label for="jenis-transaksi" class="form-label">Jenis Transaksi</label>
              <input type="text" value="transaksi-deposit-reguler" class="form-control" id="jenis-transaksi"  disabled>
            </div>
            <div class="mb-3">
              <label for="exampleDataList" class="form-label">ID Member</label>
              <input class="form-control" list="datalistOptions" id="exampleDataList" v-model="FormTransactionUang.id_member" placeholder="Ketik untuk mencari id member">
              <datalist id="datalistOptions">
                <option v-for="(mb,index) in allMember" :key="index" :value="mb.id_member">{{mb.id_member}}</option>
              </datalist>
              </div>
            <div class="mb-3">
              <label for="nominal-deposit" class="form-label">Nominal Deposit</label>
                <input type="text" v-model="FormTransactionUang.nominal_deposit" @input="updateSelectedPromo" class="form-control" id="nominal-deposit" >
            </div>
            <div class="mb-3">
              <label for="promo" class="form-label">Promo</label>
              <select  v-model="FormTransactionUang.id_promo" class="form-select" disabled>
                <option value=null>Default Value</option>
                <option v-for="(pm,index) in promos" :key="index" :value="pm.id_promo">{{pm.nama_promo}}</option>
              </select>
              <div id="promoHelp" class="form-text">{{PromoMessage}}</div>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          <hr>
        </div>
        <div>
          <div class="container-fluid form-custom p-4 text-dark mt-5" ref="sectionTable">   
                <!-- <table class="table table-dark table-striped table-bordered table-hover mt-4 scrollme">
                <thead>
                    <tr class="text-white bg-dark text-center">
                    <th>#</th>
                    <th v-for="i in max" :key="i" >Jadwal {{i}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(jd,index) in displayedJadwal" :key="index">
                    <th scope="row" class="text-white bg-dark text-center">{{index}}</th>
                    <td v-for="(column,idx) in jd" :key="idx" class="text-center"> 
                        <p>
                        Jadwal : {{column.jam_mulai}} - {{ column.jam_selesai }}
                        </p>
                        <p>
                        Nama Kelas : {{column.kelas.jenis_kelas }}  
                        </p>
                        <p>
                        Instruktur : {{ column.instruktur.nama_instruktur }}
                        </p>
                        <div v-show="toggleModeTabel">
                        <button class="btn btn-warning m-2" @click.prevent="updateDataCell(column)">Update</button>
                        <button class="btn btn-danger" @click.prevent="deleteDataCell(column)">Delete</button>
                        </div>
                    </td>
                    <td v-for="i in (max - jd.length)" :key="i" class="text-center">*</td>
                    </tr>
                </tbody>
                </table> -->
        </div>
      </div>
    </div>
    </main>
    <div class="bg light" >
        <button @click="generateStrukDepositUang">Cetak Struk</button>
        <!-- PDFFF -->
        <div  width="600px" id="pdfContent2" style=" /* display: none;*/  margin:500px;" class=" text-dark">
            <div width="600px" class="p-1 ">
                <table class="border border-dark">
                    <tr>
                      <td style="width: 50%;">
                        <strong>Gofit</strong>  
                      </td>
                      <td>
                        No Struk : {{ hasilTransaksi.transaksi_deposit_reguler.no_struk }}
                      </td>
                    </tr>
                      <td>
                        <p>Jl Centralpark No 10 Yogyakarta</p>
                      </td>
                      <td>
                        Tanggal : {{ hasilTransaksi.transaksi_deposit_reguler.tanggal_deposit }}
                      </td>
     
                    <tr></tr>
                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ hasilTransaksi.transaksi_member.id_member }}/{{ member.nama_member }}</td>
                                </tr>
                                <tr>
                                    <td >Nominal Deposit</td>
                                    <td>:</td>
                                    <td>Rp.{{hasilTransaksi.transaksi_deposit_reguler.nominal_deposit}}</td>
                                </tr>
                                <tr>
                                    <td>Bonus Deposit</td>
                                    <td>:</td>
                                    <td>{{  (hasilTransaksi.transaksi_deposit_reguler.nominal_total)-(hasilTransaksi.transaksi_deposit_reguler.nominal_deposit)}}</td>
                                </tr>
                                <tr>
                                    <td>Sisa Deposit</td>
                                    <td>:</td>
                                    <td>{{ member.total_deposit_uang}}</td>
                                </tr>
                                <tr>
                                    <td>Total Deposit</td>
                                    <td>:</td>
                                    <td>{{ parseInt(hasilTransaksi.transaksi_deposit_reguler.nominal_total) + parseInt(member.total_deposit_uang) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kasir : {{getDataPegawai().id_pegawai}}/{{ getDataPegawai().nama_pegawai }} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
  </template>


<style scoped>
.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}


.form-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}
</style>