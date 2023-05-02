<script>
import { HomeNavbar,defineComponent,$toast, BackButton } from '@/plugins/global';
import { reactive } from 'vue';

export default defineComponent({
    components : {
      HomeNavbar,
      BackButton
    },
    data(){
      return{
        FormTransactionUang : reactive({
          id_pegawai : this.getDataPegawai().id_pegawai,
          id_member : '',
          NoStruk : '',
          id_kelas : null,
          nominal_deposit_kelas : 0,
          nominal_deposit_kelas_send : 0,
          nominal_uang : 0,
          id_promo : '',
        }),
        //Array of Object
        promos : null,
        allMember : null,
        allKelas : null,

        //Object
        selectedPromo : null,
        selectedKelas : null,

        //Message
        PromoMessage : 'Dapatkan Promo Menarik!!!',
        satuanKelasMessage : '',
        summaryMessage : 'Ringkasan Transaksi : - ',

        //Watcher
        totalClasses : 0,
      }
    },
    methods : {

    // Submit Form Depost Kelas
    async submitForm()
    {
      let  confirmTransaction = false;
      const confirmDataTransaction = confirm('Apakah Anda Yakin Data Transaksinya sudah benar ? ');
      if(confirmDataTransaction){
        confirmTransaction = true;
        if(this.FormTransactionUang.id_promo == ''){
          const confirmNoPromo = confirm('Apakah Anda yakin tidak ingin menggunakan promo ');
          if(!confirmNoPromo){
            confirmTransaction = false;
          }
        }
      }
      if(confirmTransaction){
        try{
          const url = '/transaksideposituang';
          const response = await this.$http.post(url,this.FormTransactionUang);
          // console.log(response.data.total);
          // this.updateDepositBalance(response.data.total)
          $toast.success(response.data.message);
          
        }catch{
          $toast.warning('Ada kesalahan dalam inputan transaksi');
        }
      }
    },
    
    //Generate No struk berikutnya
    async generateTransactionData()
    {
      const request = await this.$http.get('/transaksiaktivasi');
      const nextNoStruk = request.data + 1
      const today = new Date();
      const year = today.getFullYear().toString().substr(-2); // Mengambil 2 digit terakhir dari tahun
      const month = ('0' + (today.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan kurang dari 10
      this.FormTransactionUang.NoStruk =  year + '.' + month + '.' + nextNoStruk;
    },
    
    //Get Data Member untuk option
    async getAllMember(){
      const dataRoute = "/member";
      const response = await this.$http.get(dataRoute)
      this.allMember = response.data.data
    },

    //Get Data Kelas untuk option kelas
    async getAllKelas(){
      const url = '/kelas';
      const response = await this.$http.get(url)
      this.allKelas = response.data.kelas;
    },


    getKelas(){
      let allKelas = this.allKelas
      this.selectedKelas = allKelas.filter((kelas) => kelas.id_kelas == this.FormTransactionUang.id_kelas)[0]
    },

    //Update After input Kelas
    updateAfterInputKelas(){
      this.getKelas()
      let {jenis_kelas, harga_kelas} = this.selectedKelas;
      this.satuanKelasMessage = `Harga Satuan Kelas ${jenis_kelas}, Rp = ${harga_kelas} / 1 x pertemuan`;
    },


    //Update After Input Jumlah Deposit Kelas
    updateAfterInputQuantity(){
      this.promo = this.availablePromo();
      if(this.promo != null){
        this.FormTransactionUang.id_promo = this.promo.id_promo;
        this.FormTransactionUang.nominal_deposit_kelas_send = this.FormTransactionUang.nominal_deposit_kelas + this.promo.bonus_promo; 
        this.summaryMessage = `Ringkasan Transaksi : Pembelian Kelas ${this.selectedKelas.jenis_kelas} (masa berlaku ${this.promo.masa_berlaku} bulan) dengan 
        deposit ${this.FormTransactionUang.nominal_deposit_kelas_send}(bayar ${this.FormTransactionUang.nominal_deposit_kelas} gratis ${this.promo.bonus_promo}), 
        biaya : ${this.FormTransactionUang.nominal_deposit_kelas} x Rp ${this.selectedKelas.harga_kelas} = Rp ${this.FormTransactionUang.nominal_uang}
        Transaksi dilakukan oleh member : ${this.FormTransactionUang.id_member}. `
      }else{
        this.FormTransactionUang.id_promo = 0;
        this.FormTransactionUang.nominal_deposit_kelas_send = this.FormTransactionUang.nominal_deposit_kelas; 
        this.summaryMessage = `Ringkasan Transaksi : Pembelian Kelas ${this.selectedKelas.jenis_kelas} (masa berlaku 1 bulan) dengan
        deposit ${this.FormTransactionUang.nominal_deposit_kelas_send} biaya : ${this.FormTransactionUang.nominal_deposit_kelas} x Rp ${this.selectedKelas.harga_kelas} = Rp ${this.FormTransactionUang.nominal_uang}
        Transaksi dilakukan oleh member : ${this.FormTransactionUang.id_member}.`
      }
    },


    //* Update Data Member Jumlah Deposit dan tanggalnya
    async updateDepositBalance(data){
      try{
        const url = `/updatedepositbalanceuang/${this.FormTransactionUang.id_member}`;
        const response = await this.$http.put(url,{total_deposit : data });
        $toast.success(response.data.message);
      }catch{
        $toast.warning('gagal update')
      }
    },

    //Generate Promo
    async getPromo(){
      const request = await this.$http.get('/promo');
      this.promos =  request.data.promo
    },


    //Dapatkan data promo yang cocok alias promo paket
    availablePromo() {
      let data = this.promos;
      let promo = null;
      data = data.filter((dt) => dt.jenis_promo === 'promo_paket');
      data.forEach((value) => {
        if (value.minimal_deposit <= this.FormTransactionUang.nominal_deposit_kelas && (promo === null || value.minimal_deposit > promo.minimal_deposit)) {
          promo = value;
        }
      });
      return promo;
    },
    

    //Get Data Pegawai Yang Login dan Bertangggung jawab
    getDataPegawai()
    {
      let pegawai = localStorage.getItem('pegawaiData');
      return JSON.parse(pegawai)
    },


    updateTotalBiayaUang() {
    const kelas = this.allKelas.find(kls => kls.id_kelas === this.FormTransactionUang.id_kelas);
    if (kelas) {
      const hargaKelas = kelas.harga_kelas;
      const totalKelas = this.FormTransactionUang.nominal_deposit_kelas;
      const totalBiayaUang = hargaKelas * totalKelas;
      this.FormTransactionUang.nominal_uang = totalBiayaUang;
    }
  }
  },

  watch: {
  'FormTransactionUang.nominal_deposit_kelas': function() {
    this.updateTotalBiayaUang();
  },
  'FormTransactionUang.id_kelas': function() {
    this.updateTotalBiayaUang();
  }
},

    mounted(){
      this.generateTransactionData();
      this.getPromo();
      this.getAllMember();
      this.getAllKelas();
    }
})

</script>

<template >
    <header>
      <home-navbar :message="'Gofit - Transaksi Deposit Paket Kelas'"></home-navbar>
    </header>
    <main>
      <div class='content text-white p-5 mb-5'>
        <div class="form-custom text-dark p-4 mb-3">
          <p><strong>Daftar Promo :</strong></p>
          <ul>
            <li v-for = "(promo,index) in promos" :key="index">
              <p v-if="promo.jenis_promo == 'promo_paket'">{{ promo.nama_promo }} Manfaat : Bonus Kelas {{ promo.bonus_promo }} dan tambahan masa berlaku lebih ++ , syarat minimal deposit : {{ promo.minimal_deposit }} sesi kelas</p>
              <p v-if="promo.jenis_promo == 'promo_reguler'">{{ promo.nama_promo }} Manfaat : Bonus Deposit Rp {{ promo.bonus_promo  }} , Syarat minimal deposit Rp : {{ promo.minimal_deposit }}</p>
            </li>
          </ul>
        </div>
        <div  class= 'container-fluid form-custom p-4 text-dark' ref="sectionForm">
          <div class="d-flex justify-content-between" >
            <h3 class="title">Transaksi Deposit Paket Kelas<span class="mdi mdi-cash-multiple ms-2"></span></h3>
          </div>
          <hr>
          <form @submit.prevent="submitForm($event)">
            <!-- No Struk -->
            <div class="mb-3">
              <label for="no-transaksi" class="form-label">No Struk</label>
                <input type="text" v-model="FormTransactionUang.NoStruk" class="form-control" id="no-transaksi" disabled>
            </div>
            <!-- Jenis Transaksi -->
            <div class="mb-3">
              <label for="jenis-transaksi" class="form-label">Jenis Transaksi</label>
              <input type="text" value="transaksi-deposit-paket" class="form-control" id="jenis-transaksi"  disabled>
            </div>
            <!-- ID Member -->
            <div class="mb-3">
              <label for="exampleDataList" class="form-label">ID Member</label>
              <input class="form-control" list="datalistOptions" id="exampleDataList" v-model="FormTransactionUang.id_member" @input="afterInputKelas" placeholder="Ketik untuk mencari id member">
              <datalist id="datalistOptions">
                <option v-for="(mb,index) in allMember" :key="index" :value="mb.id_member">{{mb.id_member}}</option>
              </datalist>
            </div>
            <!-- Pilihan Kelas -->
            <div class="mb-3">
              <label for="pilihan-kelas" class="form-label">Pilihan Kelas</label>
              <select id="pilihan-kelas" v-model="FormTransactionUang.id_kelas" @change="updateAfterInputKelas" class="form-select" >
                <option v-for="(kls,index) in allKelas" :key="index" :value="kls.id_kelas">{{kls.jenis_kelas}}</option>
              </select>
            </div>
            
            <!-- Tampilin Harga Satuan Kelas -->
            <div class="bg-danger text-white p-2 rounded" v-show="FormTransactionUang.id_kelas">
              {{ satuanKelasMessage }}
            </div>
            <!-- Total Kelas -->
            <div class="mb-3">
              <label for="total-kelas" class="form-label">Total Kelas</label>
              <!-- @input="updateAfterInputQuantity" -->  
              <input type="number" v-model="FormTransactionUang.nominal_deposit_kelas" @input="updateAfterInputQuantity" class="form-control" id="total-kelas" >
            </div>
            <!-- Total Biaya uang -->
            <div class="mb-3">
              <label for="total-kelas" class="form-label">Total Biaya Uang</label>
              <input type="text" v-model="FormTransactionUang.nominal_uang"  class="form-control" id="total-kelas" disabled>
            </div>
            <div class="mb-3">
              <label for="promo" class="form-label">Promo</label>
              <select  v-model="FormTransactionUang.id_promo" class="form-select" disabled>
                <option value=null>Default Value</option>
                <option v-for="(pm,index) in promos" :key="index" :value="pm.id_promo">{{pm.nama_promo}}</option>
              </select>
              <div id="promoHelp" class="form-text">{{PromoMessage}}</div>
            </div>
            <!-- Total Kelas  -->
            <div class="mb-3">
              <label for="total-kelas" class="form-label">Total Kelas + Bonus Promo</label>
              <!-- @input="updateAfterInputQuantity" -->  
              <input type="number" v-model="FormTransactionUang.nominal_deposit_kelas_send"  class="form-control" id="total-kelas" disabled >
            </div>
            <!-- Tampilin Bonus -->
            <div class="bg-danger text-white p-2 rounded mb-2" v-if="FormTransactionUang.nominal_deposit_kelas == FormTransactionUang.nominal_deposit_kelas_send">
              {{ summaryMessage }}
            </div>
            <div class="bg-success   text-white p-2 rounded mb-2" v-if="FormTransactionUang.nominal_deposit_kelas != FormTransactionUang.nominal_deposit_kelas_send">
              {{ summaryMessage }}
            </div>
            <div class="d-flex justify-content-between">
              <back-button className="btn btn-dark"></back-button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
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
  </template>


<style scoped>
.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}


.form-custom{
  background-color: rgba(255,255,255,0.8);
  border-radius: 10px;
}
</style>