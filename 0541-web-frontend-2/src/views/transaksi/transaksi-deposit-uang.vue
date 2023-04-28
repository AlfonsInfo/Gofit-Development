<script>
import { defineComponent } from 'vue'
import HomeNavbar from '../../components/HomeNavbar.vue';
import { $toast } from '../../plugins/notifHelper';
export default defineComponent({
    components : {
      HomeNavbar,

    },
    data(){
        return{
          FormTransactionUang : {
            jenis_transaksi : '',
            id_pegawai : this.getDataPegawai().id_pegawai,
            id_member : '',
            NoStruk : '',
            nominalDeposit : 0,
            id_promo : '',
          },
          promos : null,
          selectedPromo : null,
          PromoMessage : 'Dapatkan Promo Menarik!!!'
        }
    },
    methods : {
    async generateTransactionData()
    {
      const request = await this.$http.get('/transaksiaktivasi');
      const nextNoStruk = request.data + 1;
      const today = new Date();
      const year = today.getFullYear().toString().substr(-2); // Mengambil 2 digit terakhir dari tahun
      const month = ('0' + (today.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan kurang dari 10
      this.FormTransactionUang.NoStruk =  year + '.' + month + '.' + nextNoStruk;
    },

    async getPromo(){
      const request = await this.$http.get('/promo');
      this.promos =  request.data.promo
    },
      
    updateSelectedPromo() {
      let promo = this.availablePromo();
      let [lackOfTranscaction, {nama_promo, bonus_promo}] = this.nearestPromo();
      // console.log(lackOfTranscaction, )
        $toast.clear();
        // Menampilkan Form promo sesuai dengan promo yang bisa didapatkan
        console.log(promo)
        console.log(promo)
        if (promo && promo.id_promo != null) {
          this.FormTransactionUang.id_promo = promo.id_promo;
        }
        if(lackOfTranscaction != Infinity)
        {
            this.PromoMessage = `Transaksi kurang ${lackOfTranscaction} untuk mendapatkan promo ${nama_promo} dengan bonus ${bonus_promo}!!!`
            $toast.success(`Tambah ${lackOfTranscaction} untuk mendapatkan bonus ${bonus_promo}`,);
        }
        if(lackOfTranscaction == Infinity) { $toast.clear()}
        //  
    },


    getDataPegawai()
      {
        let pegawai = localStorage.getItem('pegawaiData');
        return JSON.parse(pegawai)
      },
    availablePromo() {
        let data = this.promos;
        let promo = null;
        data = data.filter((dt) => dt.jenis_promo === 'promo_reguler');
        data.forEach((value) => {
        if (value.minimal_deposit <= this.FormTransactionUang.nominalDeposit && (promo === null || value.minimal_deposit > promo.minimal_deposit)) {
          promo = value;
        }
      });
    return promo;
  },

      nearestPromo() {
        let data = this.promos;
        console.log(this.nearestPromo())
        let promo = null;
        let differenceFromPromo = null;
        let finalNearestPromo = Infinity;
        data = data.filter((dt) => dt.jenis_promo === 'promo_reguler');
        data.forEach((value) => {
          differenceFromPromo = value.minimal_deposit - this.FormTransactionUang.nominalDeposit;
          if (differenceFromPromo > 0 && finalNearestPromo > differenceFromPromo) {
            finalNearestPromo = differenceFromPromo;
            promo = value;
          }
        });
        // console.log('Promo terdekat:', promo);
        return [finalNearestPromo,promo];
      },  
      },
    mounted(){
      this.generateTransactionData();
      this.getPromo();
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
              <label for="nominal-deposit" class="form-label">Nominal Deposit</label>
                <input type="text" v-model="FormTransactionUang.nominalDeposit" @input="updateSelectedPromo" class="form-control" id="nominal-deposit" >
            </div>
            <div class="mb-3">
              <label for="promo" class="form-label">Promo</label>
              <select  v-model="FormTransactionUang.id_promo" class="form-select" disabled>
                <option value='0'>Default Value</option>
                <option v-for="(pm,index) in promos" :key="index" :value="pm.id_promo">{{pm}}</option>
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