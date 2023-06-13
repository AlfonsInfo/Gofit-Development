<script>
  import { HomeNavbar, $toast,   customSwal, jsPDF, reactive, CustomDateTimeFormatter,} from '@/plugins/global.js'
  // import {CustomDateTimeFormatter } from '@/plugins/global.js'
  // import function from '../../plugins/function';
  // import MenuCard from '../../components/menu-card.vue'  
  //bagaimana cara kondisi tertentu -> data tertentu
  // import {menuTransaksi} from '../../data/staticData'
  export default{
    data(){
      return {
        // menuTransaksi
        // currentDate : '',
        pegawai : {},
        allMember : null,
        allKelas : null,
        promos : null,
        jenisTransaksi : ['Transaksi Aktivasi','Transaksi Deposit Reguler','Transaksi Deposit Paket'],
        FormData : {
          tanggalTransaksi : '',
          pegawai : {},
          idMember : '',
          jenisTransaksi : null,
          nominalTransaksi : '',
          kelas : null,
          totalBiaya : '',
          id_promo :null,
          totalBayar : 0,
          kembalian : 0 ,
        },
        dataTodayTransaction : null,
        dataTransaksiAktivasi : null,
        

        //Toggle
        inputNominalToggle : true,
        inputKelasToggle : true,
        inputJenisToggle : true,
        bayarButtonToggle : true,
        prefixQuantity : 'Rp',
        showToggle : 'aktivasi',


        // Data will print
        FormPrint : reactive ({
          id_member : '',
          no_struk_transaksi : '',
          tanggal_aktivasi: '',
          nama_member : '',
          masa_aktif : '',
          id_pegawai : '',
          nama_pegawai : '',
          //*deposit reguler (uang)
          deposit : '',
          bonus_deposit : '',
          sisa_deposit : '',
          total_deposit : '',
          tanggal_depo_reguler : '',
          bonus_promo : '',
          //* depost paket
          nominal_uang : '',
          nominal_deposit_kelas : '',
          tanggal_kadeluarsa_paket : '',
          jenis_kelas : '',
          harga_kelas : '',
          harga_total : '',
        }),
        // this.FormPrint.nama_member = data.member.nama_member
        //   this.FormPrint.nominal_uang = data.deposit_kelas_paket.nominal_uang
        //   this.FormPrint.nominal_deposit_kelas = data.deposit_kelas_paket.nominal_deposit_kelas
        //   this.FormPrint.tanggal_kadeluarsa_paket = data.deposit_kelas_paket.tanggal_kadeluarsa
        //   this.FormPrint.jenis_kelas = data.deposit_kelas_paket.kelas.jenis_kelas
        //   this.FormPrint.harga_kelas = data.deposit_kelas_paket.kelas.harga_kelas
        //   this.FormPrint.harga_total = parseFloat(this.FormPrint.harga_kelas) * parseFloat(this.FormPrint.nominal_deposit_kelas ) 

      }
    },
    methods : {
      changeClass(){
        document.body.classList.replace('body-center','body-normalflow');
      },

      getCurrentDate(){
        let dateSkrg = new Date();
        this.FormData.tanggalTransaksi = `${dateSkrg.getDate()} - ${dateSkrg.getMonth() + 1} - ${dateSkrg.getFullYear()}` 
      },

      getDataPegawai()
      {
        let pegawai = localStorage.getItem('pegawaiData');
        this.FormData.pegawai =  JSON.parse(pegawai)
      },

      async getAllMember(){
        console.log('masuk sini')
        const dataRoute = "/member";
        const response = await this.$http.get(dataRoute)
        this.allMember = response.data.data
      },

      async getAllKelas(){
        const url = '/kelas';
        const response = await this.$http.get(url)
        this.allKelas = response.data.kelas;
      },

      //Generate Promo
      async getPromo(){
        const request = await this.$http.get('/promo');
        this.promos =  request.data.promo
      },

      //Dapatkan data promo yang cocok
      availablePromo(params,paramsValue) {
        //*this.FormData.nominalTransaksi -> paramsValue
      let data = this.promos;
      let promo = null;
      data = data.filter((dt) => dt.jenis_promo === params);
      data.forEach((value) => {
        if (value.minimal_deposit <= paramsValue && (promo === null || value.minimal_deposit > promo.minimal_deposit)) {
          promo = value;
        }
      });
      return promo;
      },

      //Bersihkan Form 
      cleanForm(){
        this.FormData.nominalTransaksi = '';
        this.FormData.kelas = null;
        this.FormData.totalBiaya = '';
        this.FormData.id_promo = null;
      },

      countKembalian(){
        this.FormData.kembalian = this.FormData.totalBayar - this.FormData.totalBiaya;
      },

      cekTotalBayarValid(){
        if(this.FormData.totalBayar.length == null){
          $toast.warning('Total Pembayaran diinputkan!')
          return false;
        }else if(this.FormData.totalBayar < this.FormData.totalBiaya){
          $toast.warning('Total Pembayaran tidak boleh kurang dari biaya total !')
          return false;
        }
        return true;
      },


      cekTransaksiDepoRegulerValid(){
        if(this.FormData.jenisTransaksi == 'Transaksi Deposit Reguler'){
          if(this.FormData.totalBiaya >= 500000){
            return true;
          }
          $toast.info('Minimal Transaksi Deposit Reguler 500000')
          return false;
        }
        return true;
      },

      submitForm(){
        event.preventDefault();
        if( this.cekTransaksiDepoRegulerValid() && this.cekTotalBayarValid()  ){
          customSwal(`Lakukan ${this.FormData.jenisTransaksi} ?`, 'question','blue','Ya',this.prosesTransaksi)
        }

      },

      async TransaksiAktivasi(){
        try{
            const data =  {
              id_pegawai : this.FormData.pegawai.id_pegawai,
              id_member : this.FormData.idMember
            }
            console.log('data', data);
            //transaksiaktivasi2 simpan transaksi + update expired datenya
            const response = await this.$http.post('/aktivasi',data);
            console.log('response' , response)
            this.cetakStrukAktivasi(response.data.data,'langsung');
            // generate struk aktivasi()
            $toast.success('Transaksi Berhasil')
        }catch{
          $toast.warning('Aktivasi Gagal')
        }
      },


      async DepoReguler(){
        try{
          const data =  {
            id_pegawai : this.FormData.pegawai.id_pegawai,
            id_member : this.FormData.idMember,
            nominal_deposit : this.FormData.nominalTransaksi,
            id_promo : this.FormData.id_promo,
          }
          const url = '/transaksideposituang';
          const response = await this.$http.post(url,data);
          this.cetakStrukDepoReguler(response.data.data,'langsung');
          $toast.success(response.data.message);        
        }catch{
          $toast.warning('Transaksi Deposit Reguler Gagal!')
        }
      },

      async DepoPaket(){
        try{
          const data  = {
            id_pegawai : this.FormData.pegawai.id_pegawai,
            id_member : this.FormData.idMember,
            id_promo : this.FormData.id_promo,
            id_kelas : this.FormData.kelas.id_kelas,
            nominal_uang : this.FormData.totalBiaya,
            nominal_deposit_kelas : this.FormData.nominalTransaksi
          }
          console.log(data);
          const url = '/transaksidepositpaket';
          const response = await this.$http.post(url,data);
          this.cetakStrukDepoPaket(response.data.data,'langsung');
          $toast.success(response.data.message);        
        }catch(error){
          if(error.response.data.message != undefined || error.response.data.message != null ){
            $toast.warning(error.response.data.message)
          }else{
            $toast.warning('Transaksi Deposit Paket Gagal!');
          }
        }
      },

      //Proses Trasaksi
      async prosesTransaksi(){
        // console.log(this.FormData.jenisTransaksi);
        if(this.FormData.jenisTransaksi == 'Transaksi Aktivasi'){
          //Proses Aktivasi
          console.log('Proses Aktivasi')
          await this.TransaksiAktivasi();
        }else if(this.FormData.jenisTransaksi == 'Transaksi Deposit Reguler'){
          await this.DepoReguler();
        }else if(this.FormData.jenisTransaksi == 'Transaksi Deposit Paket'){
          await this.DepoPaket();
          console.log('Proses Depo Paket')
        }else{
          console.log('Jenis Transaksi Tidak Ada')
        }
        this.getTodayTransaction();
        this.FormData.idMember = '';
        this.cleanForm();
      },


      async getTodayTransaction(){
        const url = '/transaksihariini';
        const response = await this.$http.get(url);
        this.dataTodayTransaction = response.data.data;
      },

      setDataCetakAktivasi(data){
        console.log('data di fungsi cetka', data)
        try{
          this.FormPrint.no_struk_transaksi = data.transaksi_aktivasi.no_struk 
          this.FormPrint.id_member = data.transaksi_member.id_member
          this.FormPrint.id_pegawai = this.FormData.pegawai.id_pegawai
          this.FormPrint.tanggal_aktivasi = CustomDateTimeFormatter.dateTimeSlash(data.transaksi_aktivasi.tanggal_aktivasi, '/') ;
          this.FormPrint.masa_aktif = CustomDateTimeFormatter.reverseDate(data.transaksi_aktivasi.tanggal_kadeluarsa, '/') 
          this.FormPrint.nama_member = data.member.nama_member
          this.FormPrint.nama_pegawai = this.FormData.pegawai.nama_pegawai
          console.log('data', this.FormPrint);
        }catch(e){
          console.log(e);
        }
      },

      setDataCetakPaket(data){
        console.log('data di fungsi cetak paket', data)
        try{
          this.FormPrint.id_pegawai = this.FormData.pegawai.id_pegawai
          this.FormPrint.nama_pegawai = this.FormData.pegawai.nama_pegawai
          this.FormPrint.id_member = data.member.id_member
          this.FormPrint.nama_member = data.member.nama_member
          this.FormPrint.no_struk_transaksi = data.transaksi_deposit_paket.no_struk_transaksi
          this.FormPrint.tanggal_depo_paket = CustomDateTimeFormatter.dateTimeSlash(data.transaksi_deposit_paket.tanggal_kadeluarsa, '/', 'T') 
          this.FormPrint.nominal_uang = data.transaksi_deposit_paket.nominal_uang
          this.FormPrint.nominal_deposit_kelas = data.transaksi_deposit_paket.nominal_deposit_kelas
          this.FormPrint.tanggal_kadeluarsa_paket  = CustomDateTimeFormatter.reverseDate(data.transaksi_deposit_paket.tanggal_kadeluarsa,'/', 'T') 
          this.FormPrint.jenis_kelas = data.kelas.jenis_kelas
          this.FormPrint.harga_kelas = data.kelas.harga_kelas
          this.FormPrint.harga_total = parseFloat(this.FormPrint.harga_kelas) * parseFloat(this.FormPrint.nominal_deposit_kelas ) 
          this.FormPrint.bonus_promo = data.promo.bonus_promo
        }catch(e){
          console.log(e);
        }
      },
      setDataCetakReguler(data){
        console.log('data di fungsi cetak reguler', data)
        try{
          this.FormPrint.no_struk_transaksi = data.transaksi_deposit_reguler.no_struk 
          this.FormPrint.id_member = data.transaksi_member.id_member
          this.FormPrint.id_pegawai = this.FormData.pegawai.id_pegawai
          this.FormPrint.nama_member = data.member_sebelum.nama_member
          this.FormPrint.nama_pegawai = this.FormData.pegawai.nama_pegawai
          // belum tau
          this.FormPrint.sisa_deposit = data.member_sebelum.sisa_deposit
          this.FormPrint.nominal_deposit = data.transaksi_deposit_reguler.sisa_deposit
          this.FormPrint.nominal_total = data.transaksi_deposit_reguler.nominal_total
          this.FormPrint.bonus_promo = data.promo.bonus_promo
          this.FormPrint.tanggal_depo_reguler = CustomDateTimeFormatter.dateTimeSlash(data.transaksi_deposit_reguler.created_at, '/', 'T') 

          // 
          console.log('data', this.FormPrint);
        }catch(e){
          console.log(e);
        }
      },

      cetakStrukAktivasi(data,way){
        if(way == 'table'){
          this.FormPrint.id_member = data.id_member
          this.FormPrint.no_struk_transaksi = data.no_struk_transaksi
          this.FormPrint.tanggal_aktivasi = CustomDateTimeFormatter.dateTimeSlash(data.aktivasi.tanggal_aktivasi,'/');
          console.log(this.FormPrint.tanggal_aktivasi)
          this.FormPrint.nama_member = data.member.nama_member
          this.FormPrint.tanggal_struk = data.created_at
          this.FormPrint.masa_aktif = data.aktivasi.tanggal_kadeluarsa
          this.FormPrint.id_pegawai = data.id_pegawai
          this.FormPrint.nama_pegawai = data.pegawai.nama_pegawai
        }else{
          console.log('masuk di else cetakStrukAktivasi')
          this.setDataCetakAktivasi(data)
        }
          this.templatePDF('#pdfContent',['250','100'])
      },
      cetakStrukDepoReguler(data,way){
        if(way == 'table'){
          console.log(data.deposit_uang)
          this.FormPrint.id_member = data.id_member
          this.FormPrint.no_struk_transaksi = data.transaksi_deposit_reguler.no_struk_transaksi
          this.FormPrint.nama_member = data.member.nama_member
          this.FormPrint.id_pegawai = data.id_pegawai
          this.FormPrint.nama_pegawai = data.pegawai.nama_pegawai
          this.FormPrint.sisa_deposit = data.deposit_uang.sisa_deposit
          this.FormPrint.nominal_deposit = data.deposit_uang.nominal_deposit
          this.FormPrint.nominal_total = data.deposit_uang.nominal_total
          this.FormPrint.bonus_promo = data.deposit_uang.promo.bonus_promo
          this.FormPrint.tanggal_depo_reguler = CustomDateTimeFormatter.dateTimeSlash(data.deposit_uang.created_at, '/', 'T') 
          console.log(this.FormPrint)
        }else{
          this.setDataCetakReguler(data);
        }
        this.templatePDF('#ContentDepoReguler', ['300','100'])
      },

      cetakStrukDepoPaket(data,way){

        console.log(data)
        if(way == 'table'){
          this.FormPrint.id_pegawai = data.id_pegawai
          this.FormPrint.nama_pegawai = data.pegawai.nama_pegawai
          this.FormPrint.id_member = data.id_member
          this.FormPrint.no_struk_transaksi = data.transaksi_deposit_paket.no_struk
          this.FormPrint.tanggal_depo_paket = CustomDateTimeFormatter.dateTimeSlash(data.deposit_kelas_paket.created_at, '/', 'T') 
          this.FormPrint.nama_member = data.member.nama_member
          this.FormPrint.nominal_uang = data.deposit_kelas_paket.nominal_uang
          this.FormPrint.nominal_deposit_kelas = data.deposit_kelas_paket.nominal_deposit_kelas
          this.FormPrint.tanggal_kadeluarsa_paket = data.deposit_kelas_paket.tanggal_kadeluarsa
          this.FormPrint.jenis_kelas = data.deposit_kelas_paket.kelas.jenis_kelas
          this.FormPrint.harga_kelas = data.deposit_kelas_paket.kelas.harga_kelas
          this.FormPrint.harga_total = parseFloat(this.FormPrint.harga_kelas) * parseFloat(this.FormPrint.nominal_deposit_kelas ) 
          this.FormPrint.bonus_promo = data.deposit_kelas_paket.promo.bonus_promo
          console.log(this.FormPrint);
        }else{
          this.setDataCetakPaket(data)
        }
        this.templatePDF('#ContentDepoPaket', ['300','100'])
      },

      templatePDF(selector, format){
        var elementHTML = document.querySelector(selector);
            elementHTML.style.display = "block";
            elementHTML.style.fontSize = '5px';

            //Spasi
            elementHTML.style.lineHeight = '1.2'; 
            elementHTML.style.margin = '0';
            elementHTML.style.padding = '0';
            
            let doc = new jsPDF({
                orientation: 'l', // orientasi landscape
                unit: 'mm', // satuan millimeter
                format: format, // ukuran kertas A4
            });

            doc.html(elementHTML, {
            callback: function (doc) {
                doc.save('file.pdf');
                elementHTML.style.display = "none";
            },
            x: 10,
            y: 10
            });
      }
    },
    //Akhir dari method

    

    
    mounted(){
      this.changeClass()

      //* get current date
      this.getCurrentDate();
      //* get current pegawai
      this.getDataPegawai();
      //* get pilihan member
      this.getAllMember();
      //* get pilihan kelas
      this.getAllKelas();
      
      console.log(CustomDateTimeFormatter);
      //* promo
      this.getPromo();
      //*get pilihan kelas

      //*get today transaction for table
      this.getTodayTransaction();

    },

    computed:{
      filterDepoUang(){
        if(this.dataTodayTransaction != null){
          return this.dataTodayTransaction.filter(row => row.deposit_uang != null)
        }
        return null;
      },
      filterAktivasi(){
        if(this.dataTodayTransaction != null){
          return this.dataTodayTransaction.filter(row => row.aktivasi != null)
        }
        return null;
      },
      filterDepoKelas(){
        if(this.dataTodayTransaction != null){
          return this.dataTodayTransaction.filter(row => row.deposit_kelas_paket != null)
        }
        return null;
      },
    },

    watch: {

      'FormData.idMember' : function(newIdMember){
        if(newIdMember.length != 0){
          this.inputJenisToggle = false;
        }else{
          //butuh else agar saat perubahan kondisi kembali menutup
          this.inputJenisToggle = true;
          this.inputKelasToggle = true;
          this.inputNominalToggle = true;

        }
      },
      'FormData.jenisTransaksi': function(newJenisTransaksi) {
        //Reset form saat ubah jenis
        this.cleanForm(); 
        if (newJenisTransaksi === 'Transaksi Deposit Paket') {
          this.FormData.nominalTransaksi = 5
          this.inputKelasToggle = false;
          this.inputNominalToggle = false;
          this.prefixQuantity = 'Jumlah Sesi : '
        } else if(newJenisTransaksi === 'Transaksi Deposit Reguler'){
          this.inputKelasToggle = true;
          this.inputNominalToggle = false;
          this.prefixQuantity = 'Rp : '
        }else if(newJenisTransaksi === 'Transaksi Aktivasi'){
          this.FormData.totalBiaya = 3000000
          this.inputKelasToggle = true;
          this.inputNominalToggle = true;
        }else{
          this.inputKelasToggle = true;
          this.inputNominalToggle = true;
        }

      },

      'FormData.nominalTransaksi' : function(newNominal){
        let params = '';
        let dataPromo = null;

        let assignPromo = () => {
          dataPromo = this.availablePromo(params,newNominal);
          if(dataPromo !=null){
            this.FormData.id_promo  = this.availablePromo(params, newNominal).id_promo;
          }else{
            this.FormData.id_promo = null;
          }
        }
        if(this.FormData.jenisTransaksi == 'Transaksi Deposit Reguler'){
          params = 'promo_reguler';
          this.FormData.totalBiaya = this.FormData.nominalTransaksi;
          assignPromo();
        }else if(this.FormData.jenisTransaksi == 'Transaksi Deposit Paket'){
          params = 'promo_paket';
          assignPromo();
        }
      },

      'FormData.totalBayar' : function(){
        this.countKembalian();
      },

      FormData : {
        handler(newFormData){
          if( newFormData.jenisTransaksi == 'Transaksi Deposit Paket'){
            if(newFormData.kelas != null && newFormData.nominalTransaksi.length != 0){
              console.log('disini woy')
              this.FormData.totalBiaya = newFormData.kelas.harga_kelas * newFormData.nominalTransaksi
            }else{
              this.FormData.totalBiaya = 0;
            }
          }

          if(newFormData.idMember.length != 0 && (newFormData.totalBiaya != 0 || newFormData.totalBiaya == null)){
            this.bayarButtonToggle = false;
          }else{
            this.bayarButtonToggle = true;
          }
        },
        deep : true,
      }
    },


    components : {  
      // LogoutButton,
      HomeNavbar,
      // MenuCard
    }
  }
</script>
<template >
  <header>
    <home-navbar :message = "'Transaksi Member'"></home-navbar>
  </header>
  <main class="">
    <div class="pegawai-mo p-5">
      <div class="bg-white text-dark p-4 border rounded ">
        <div class="row align-items-start">
          <h2>Transaksi </h2>
          <div class="price-list col">
            <p><strong>Daftar Harga</strong></p>
            <ol>
              <li>Aktivasi : Rp 3.000.000</li>
              <li>Kelas : Rp 150.000/sesi hingga - Rp 200.000/sesi</li>
            </ol>
        </div>
        <div class="promo-list col">
          <!-- <p><strong>Daftar Promo</strong></p> -->
          <p><strong>Promo Deposit Reguler</strong></p>
          <ol>
            <li>Setiap pembelian deposit reguler Rp 3.000.000 dapatkan bonus deposit reguler Rp 300.000</li>
          </ol>
        </div>
        <div class="col">
          <p><strong>Promo Deposit Paket</strong></p>
          <ol>
            <li>Setiap pembelian deposit kelas paket 5 dapatkan bonus 1 kelas (masa aktif 1 bulan)</li>
            <li>Setiap pembelian deposit kelas paket 10 dapatkan bonus 3 kelas (masa aktif 3 bulan)</li>
          </ol>
        </div>
      </div>
        <hr>
        <form @submit.prevent="submitForm($event)">
        <div class="row align-items-start">
          <h4>Menu Transaksi</h4>
            <!-- * Kolom Kiri -->
            <div class="col">
                <!-- * Tanggal -->
              <div class="col-md-11 m-3">
                <label for="tanggal-transaksi" class="form-label">Tanggal Transaksi</label>
                  <input type="text"  v-model="FormData.tanggalTransaksi"  class="form-control" id="tanggal-transaksi" disabled>
              </div>
              <!-- * Kasir ID / Name -->
              <div class="col-md-11 m-3">
                <label for="no-transaksi" class="form-label">Kasir</label>
                <input type="text" :value="FormData.pegawai.id_pegawai + ' - ' + FormData.pegawai.nama_pegawai" class="form-control" disabled>
              </div>
              <!-- * Select Member -->
              <div class="col-md-11 m-3">
               <label for="exampleDataList" class="form-label">ID Member</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList"  v-model="FormData.idMember" placeholder="Ketik untuk mencari id member">
                  <datalist id="datalistOptions">
                <option v-for="(mb,index) in allMember" :key="index" :value="mb.id_member">{{mb.id_member + ' - ' + mb.nama_member}}</option>
                </datalist>
              </div>
              <div class="m-3">
                <h4>Ringkasan Transaksi</h4>
                <div class="row">
                  <div class="col-md-4">
                    <p>Member</p>
                    <p>Jenis Transaksi</p>
                    <p>Total Biaya</p>
                  </div>
                  <div class="col-md-1">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                  </div>
                  <div class="col">
                    <p>{{ FormData.idMember }}</p>
                    <p>{{ FormData.jenisTransaksi }}</p>
                    <p>{{ FormData.totalBiaya }}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- * Kolom Kanan -->
            <div class="col">
              <!-- * Jenis Transaksi -->
              <div  class="col-md-11 m-3">
                <label  class="form-label" >Jenis Transaksi</label>
                <select   class="form-select" v-model="FormData.jenisTransaksi" :disabled="inputJenisToggle">
                  <option value=null>Pilih Transaksi</option>
                  <option v-for="(pm,index) in jenisTransaksi" :key="index" :value="pm">{{pm}}</option>
                </select>
              </div>
              <!-- v-model="FormTransactionUang.id_promo" -->
              
              <!-- * Nominal Uang / Kelas  (Jenis Kelas) -->
              <div class="row">
                <div class="col-md-5 m-3">
                  <label for="no-transaksi" class="form-label">Nominal Transaksi</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">{{ prefixQuantity }}</span>
                    </div>
                    <input v-if="FormData.jenisTransaksi == 'Transaksi Deposit Reguler'" type="text"  class="form-control" v-model="FormData.nominalTransaksi" id="no-transaksi" :disabled="inputNominalToggle">
                    <select v-else-if="FormData.jenisTransaksi == 'Transaksi Deposit Paket'"  class="form-control" v-model="FormData.nominalTransaksi" id="no-transaksi" :disabled="inputNominalToggle">
                      <option :value="5" >5</option>
                      <option :value="10">10</option>
                    </select>
                    <input v-else type="text"  class="form-control" v-model="FormData.totalBiaya" id="no-transaksi" disabled>
                  </div>
                </div>
                <div class="col-md-5 m-3">
                  <label for="no-transaksi" class="form-label">Pilihan Kelas</label>
                  <select   class="form-select" v-model="FormData.kelas" :disabled="inputKelasToggle">
                  <option value=null>Pilih Kelas</option>
                  <option v-for="(pm,index) in allKelas" :key="index" :value="pm" >{{ pm.jenis_kelas }}</option>
                </select>                </div>  
              </div>
              <!-- * Promo -->
              <div  class="col-md-11 m-3">
                <label for="promo" class="form-label" >Promo</label>
                <select   class="form-select" v-model="FormData.id_promo" disabled>
                  <option value=null>Pilih Promo</option>
                  <option v-for="(pm,index) in promos" :key="index" :value="pm.id_promo" >{{(pm.jenis_promo === 'promo_reguler') ?  pm.nama_promo + ` (Bonus ${pm.bonus_promo})`: pm.nama_promo + ` (Bonus ${pm.bonus_promo} sesi, masa berlaku ${pm.masa_berlaku} bulan)`}}</option>
                </select>
              </div>
              <!-- * Tagihan -->
              <div class="col-md-11 m-3">
                <label for="no-transaksi" class="form-label">Total Biaya</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" v-model="FormData.totalBiaya" class="form-control" id="no-transaksi" disabled>
                </div>
              </div>
              <!-- * Yang dibayarkan   -->
              <div class="col-md-11 m-3">
                <label for="total-bayar" class="form-label">Total Bayar</label>
                  <input type="text"  class="form-control" v-model="FormData.totalBayar" id="total-bayar">
              </div>
              <!-- * Kembalian  -->
              <div class="col-md-11 m-3">
                <label for="no-transaksi" class="form-label">Kembalian</label>
                  <input type="text"  class="form-control" v-model="FormData.kembalian" id="no-transaksi" disabled>
              </div>
              <!-- * Cancel dan Konfirmasi -->
              <div class="row">
                <div class="col-md-8"></div>
                <div class="col">
                  <button class="btn btn-danger m-2" type="button">Cancel</button>
                  <button class="btn btn-primary m-2"  :disabled="bayarButtonToggle" >Bayar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <select class="btn btn-primary mt-3" v-model="showToggle">
        <option value="aktivasi">aktivasi</option>
        <option value="uang">deposit reguler</option>
        <option value="kelas">deposit paket</option>
      </select>
      <div class="mt-3 p-4 border rounded text-dark bg-white">
          <h3>Transaksi Hari ini</h3>
          <!-- AKTIVASI -->
          <table v-if="showToggle =='aktivasi'" id="example" class="#example table table-striped filters">
            <thead>
              <tr>
                <th>No Struk</th>
                <th>Jenis Transaksi</th>
                <th>Pegawai</th>
                <th>Member</th>
                <th>Tanggal Aktivasi</th>
                <th>Tanggal Kadeluarsa</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row,key) in filterAktivasi" :key="key">
                <td>{{ row.no_struk_transaksi }}</td>
                <td>{{ row.jenis_transaksi }}</td>
                <td>{{ row.id_pegawai }}</td>
                <td>{{ row.id_member }}</td>
                <td>{{ (row.aktivasi.tanggal_aktivasi !=null)  ? row.aktivasi.tanggal_aktivasi.split(' ')[0] : '' }}</td>
                <td>{{ (row.aktivasi.tanggal_kadeluarsa != null) ?  row.aktivasi.tanggal_kadeluarsa.split(' ')[0]  : ' '}}</td>
                <td>
                  <button class="btn btn-primary" @click="cetakStrukAktivasi(row,'table')">Cetak Struk</button>
                </td>
              </tr>
            </tbody>
          </table>
          <table v-if="showToggle=='uang'" id="example" class="#example table table-striped filters">
            <thead>
              <tr>
                <th>No Struk</th>
                <th>Jenis Transaksi</th>
                <th>Pegawai</th>
                <th>Member</th>
                <th>Waktu Deposit</th>
                <th>Nominal Deposit</th>
                <th>Promo</th>
                <th>Saldo(New)</th>
                <!-- <th>Aksi</th> -->
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row,key) in filterDepoUang" :key="key">
                <td>{{ row.no_struk_transaksi }}</td>
                <td>{{ row.jenis_transaksi }}</td>
                <td>{{ row.id_pegawai }}</td>
                <td>{{ row.id_member }}</td>
                <td>{{ row.deposit_uang.tanggal_deposit }} </td>
                <td>{{ row.deposit_uang.nominal_deposit}}</td>
                <td>{{ row.deposit_uang.promo.nama_promo}}</td>
                <!-- <td>{{ row.deposit_uang.nominal_total}}</td> -->
                <!-- <td>{{ row }}</td> -->
                <td>
                  <button class="btn btn-primary" @click="cetakStrukDepoReguler(row)">Cetak Struk</button>
                </td>
              </tr>
            </tbody>
          </table>
          <table v-if="showToggle=='kelas'" id="example" class="#example table table-striped filters">
            <thead>
              <tr>
                <th>No Struk</th>
                <th>Jenis Transaksi</th>
                <th>Pegawai</th>
                <th>Member</th>
                <th>Tanggal Deposit</th>
                <th>Nominal Uang</th>
                <th>Kuota Sesi(Kelas)</th>
                <th>Promo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row,key) in filterDepoKelas" :key="key">
                <td>{{ row.no_struk_transaksi }}</td>
                <td>{{ row.jenis_transaksi }}</td>
                <td>{{ row.id_pegawai }}</td>
                <td>{{ row.id_member }}</td>
                <td>{{ row.deposit_kelas_paket.tanggal_deposit }}</td>
                <td>{{ row.deposit_kelas_paket.nominal_uang }}</td>
                <td>{{ row.deposit_kelas_paket.nominal_deposit_kelas }} ({{ row.deposit_kelas_paket.kelas.jenis_kelas }} )</td>
                <td>+{{row.deposit_kelas_paket.promo.bonus_promo}} ({{ row.deposit_kelas_paket.promo.nama_promo }})</td>
                <td>
                  <button class="btn btn-primary" @click="cetakStrukDepoPaket(row,'table')">Cetak Struk</button>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
    <div  width="600px" id="pdfContent" style=" display: none;" class="text-dark">
      <table style="border: 1px solid black;" >
        <tr>
          <td style="width: 65%;">
              <p><strong>GoFit</strong></p>
              <p>Jl. Centralpark No. 10 Yogyakarta</p>
          </td>
          <td>
            <tr>
              <td><p>No Struk</p></td>
              <td>:</td>
              <td>{{ FormPrint.no_struk_transaksi }}</td>
            </tr>
            <tr>
              <td><p>Tanggal</p></td>
              <td><p>:</p></td>
              <td>{{ FormPrint.tanggal_aktivasi }}</td>
            </tr>
          </td>
        </tr>
        <tr style="height: 1mm;"></tr>
        <tr>
          <table>
          <tr>
            <td style="width:50%"><strong>Member</strong></td>
            <td><strong>:</strong></td>
            <td>{{ FormPrint.id_member }} / {{FormPrint.nama_member}}</td>
          </tr>
          <tr>
            <td>Aktivasi Tahunan</td>
            <td>:</td>
            <td>Rp.3000.000,-</td>
          </tr>
          <tr>
            <td>Masa Aktif Member</td>
            <td>:</td>
            <td>{{ FormPrint.masa_aktif }}</td>
          </tr>
        </table>
      </tr>
      <tr>
        <td></td>
        <td>
          <tr>Kasir : {{ FormPrint.id_pegawai }} / {{ FormPrint.nama_pegawai }} </tr>
          <!-- <tr>:</tr> -->
          <!-- <tr></tr> -->
        </td>
      </tr>
    </table>
  </div>
  <div  width="600px" id="ContentDepoReguler" style=" display: none;" class="text-dark">
            <div width="600px" class="p-1 ">
                <table class="border border-dark">
                    <tr>
                      <td style="width: 50%;">
                        <strong>Gofit</strong>  
                      </td>
                      <td>
                        No Struk : {{ FormPrint.no_struk_transaksi }}
                      </td>
                    </tr>
                      <td>
                        <p>Jl Centralpark No 10 Yogyakarta</p>
                      </td>
                      <td>
                        Tanggal : {{ FormPrint.tanggal_depo_reguler }}
                      </td>
     
                    <tr></tr>
                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{FormPrint.id_member }}/{{ FormPrint.nama_member }}</td>
                                </tr>
                                <tr>
                                    <td >Nominal Deposit</td>
                                    <td>:</td>
                                    <td>Rp. {{FormPrint.nominal_deposit}}</td>
                                </tr>
                                <tr>
                                    <td>Bonus Deposit</td>
                                    <td>:</td>
                                    <td>Rp. {{ FormPrint.bonus_promo}}</td>
                                </tr>
                                <tr>
                                    <td>Sisa Deposit</td>
                                    <td>:</td>
                                    <td>Rp. {{ FormPrint.nominal_total}}</td>
                                </tr>
                                <tr>
                                    <td>Total Deposit</td>
                                    <td>:</td>
                                    <td>{{ FormPrint.nominal_total }}</td>
                                    <!-- <td>{{ parseInt(hasilTransaksi.member_sesudah.total_deposit_uang) }}</td> -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kasir : {{ FormPrint.id_pegawai }} / {{ FormPrint.nama_pegawai }} </td>
                    </tr>
                    <!-- <tr>
                      <td></td>
                    </tr> -->
                </table>
            </div>
        </div>
  <div  width="600px" id="ContentDepoPaket" style=" display: none;" class="text-dark">
    <div width="600px" class="p-1 ">
                <table class="border border-dark">
                    <tr>
                      <td style="width: 50%;">
                        <strong>Gofit</strong>  
                      </td>
                      <td>
                        No Struk : {{ FormPrint.no_struk_transaksi }}
                      </td>
                    </tr>
                      <td>
                        <p>Jl Centralpark No 10 Yogyakarta</p>
                      </td>
                        <td>Tanggal : {{ FormPrint.tanggal_depo_paket }}</td>
                    <tr></tr>
                    <tr>
                        <td>
                            <table>
                                <tr style="width: 80%;">
                                    <td><strong>Member</strong></td>
                                    <td>:</td>
                                    <td>{{ FormPrint.id_member }}/{{ FormPrint.nama_member }}</td>
                                </tr>
                                <tr>
                                    <td > Deposit Bayar ({{ FormPrint.nominal_deposit_kelas}} gratis {{FormPrint.bonus_promo}})</td>
                                    <td>:</td>
                                    <td>Rp.{{FormPrint.nominal_uang}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelas</td>
                                    <td>:</td>
                                    <td> {{FormPrint.jenis_kelas }} </td>
                                </tr>
                                <tr>
                                    <td>Total Deposit {{ FormPrint.jenis_kelas }}</td>
                                    <td>:</td>
                                    <td>{{ parseInt(FormPrint.nominal_deposit_kelas) + parseInt(FormPrint.bonus_promo)}}</td>
                                </tr>
                                <tr>
                                    <td>Masa Berlaku sampai dengan</td>
                                    <td>:</td>
                                    <td>{{ FormPrint.tanggal_kadeluarsa_paket }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kasir : {{ FormPrint.id_pegawai }} / {{ FormPrint.nama_pegawai }} </td>
                    </tr>
                </table>
            </div>
  </div>
  </main>

</template>

<style scoped>
.pegawai-mo{
  height: 200vh;
  background-color: rgba(0,0,0,0.7  );
}

#pdfContent p{
  margin: 0;
}
</style>
