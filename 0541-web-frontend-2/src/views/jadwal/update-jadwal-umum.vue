<script>
import HomeNavbar from '../../components/HomeNavbar.vue';
import BackButton from '../../components/BackButton.vue';
import { reactive } from 'vue';
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
        days : ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'],
        selectedDay  : 'senin',
        instrukturs : ({}),
        kelas : ({}),
        jadwals  : reactive({}),
        jadwal : reactive({})

        }
    },

    methods : {

        //Method Navigasi
        goBack() {
            if ($toast) {
            this.toast.goAway(0);
            }
        },

        //Method Get Data

        async getAllInstruktur() {
            const dataRoute = "/instruktur";
            const request = await this.$http.get(dataRoute)
            this.instrukturs.value = request.data.data 
        },

        async getAllKelas ()  {
            const dataRoute = "/kelas";
            const request = await this.$http.get(dataRoute)
            this.kelas.value = request.data.kelas
        },
        
        async getAllJadwal() {
            const dataRoute = "/jadwalumum";
            const request = await this.$http.get(dataRoute)
            this.jadwals.value = request.data.data
        },


        //Update Method

        submitForm(){
            console.log(event)
            event.preventDefault(); // hindari default form submission
            // kode untuk memproses data form
            this.updateJadwal();
        },


        isValid({hari, id_instruktur,id_kelas,jam_mulai,jam_selesai}){
            let status = true;  
            if (!hari) {
                $toast.warning('Hari harus diisi');
                status = false;
            }
            // const regex = /^\d{4}-\d{2}-\d{2}$/;
            if (!id_instruktur) {
                $toast.warning('Nama Instruktur Harus Diisi');
                status = false;
            }
            if (!id_kelas) {
                $toast.warning('Kelas harus diisi');
                status = false;
            }
            if(!jam_mulai){
                $toast.warning('Jam Mulai harus diisi');
                status = false;
            }
            if(!jam_selesai){
                $toast.warning('Jam Selesai harus diisi');
                status = false;
            }
            if(parseInt(jam_mulai.replace(':',''))> parseInt(jam_selesai.replace(':',''))){
                $toast.warning(`Jam selesai harus lebih besar dari Jam Mulai`);
                status = false;
            }
            return status;
    },

        isNotConflict(jadwal){
            //Default tidak ada konflik
            let status = true;

            //Mapping data ke content
            let content = Object.values(this.jadwals.value).flatMap(data => Object.values(data)).flat();

                console.log('input jadwal', jadwal)

            let filteredData = content.filter((values) => {
                const jadwalMulaiA = parseInt(jadwal.jam_mulai.replace(':',''));
                const jadwalSelesaiA = parseInt(jadwal.jam_selesai.replace(':',''))
                const jadwalMulaiB = parseInt(values.jam_mulai.replace(':',''));
                const jadwalSelesaiB = parseInt(values.jam_selesai.replace(':',''))


                //Hari Intruktur sama
                const conditionHari = (values.hari == jadwal.hari) ? true : false
                const conditionInstruktur = (values.id_instruktur== jadwal.id_instruktur) ? true : false
                //Jadwal yang overlaps
                const conditionjadwalConflict = ( jadwalMulaiA < jadwalSelesaiB && jadwalSelesaiA > jadwalMulaiB)

                // Debugging
                // console.log(jadwalMulaiA, '<', jadwalSelesaiB ,'&&', jadwalSelesaiA,'>', jadwalMulaiA)
                
                if(conditionHari && conditionInstruktur && conditionjadwalConflict){
                  if(values.id_jadwal_umum != jadwal.id_jadwal_umum){
                    console.log('kondisi konflik jadwal' , conditionjadwalConflict)
                    $toast.warning('Jadwal Bentrok  ' + values.kelas.jenis_kelas)
                    return values
                  }
                }
                return null
            })
            if(filteredData.length > null)
            {
            status = false;
            }
            console.log(status)
            return status;
        },
        async updateJadwal(){
            const statusValidate = this.isValid(this.jadwal)
            const statusJadwalInstruktur = this.isNotConflict(this.jadwal)
            if( statusValidate && statusJadwalInstruktur){
                try{
                const url = `/jadwalumum/${this.jadwal.id_jadwal_umum}`; 
                const request = await this.http.put(url,this.jadwal); // ; 
                $toast.success(request.data.message)
                this.router.push({name:'jadwal-umum'})
              }catch{
                $toast.warning('Gagal Menambahkan Data')
                }
            }
        }
    },

    mounted(){
        this.getAllInstruktur();
        this.getAllKelas();
        this.getAllJadwal();
        this.jadwal = this.$route.query
        console.log(this.jadwal)   
        window.onpopstate = () => {
            this.goBack();
        }
    },
})
</script>
<template >
<header>
  <home-navbar :message="'Gofit -  Tambah Data Jadwal'"></home-navbar>
</header>
<main>
  <div class='content text-white p-5 mt-5'>
    <h2></h2>
    <div  class= 'container-fluid form-custom p-4 text-dark' ref="sectionForm">
      <div class="d-flex justify-content-between" >
        <h3 class="title">Form Tambah Jadwal <span class="mdi mdi-calendar"></span></h3>
        <!-- <button class="btn btn-outline-dark" @click="scrollToSection('sectionTable')">Cek Jadwal</button> -->
        </div>
      <hr>
      <form @submit.prevent="submitForm($event)">
        <!-- Hari -->
        <div class="mb-3">
          <label for="nama_member" class="form-label">Pilih Hari Untuk Melaksanakan Kelas</label>
          <select v-model="jadwal.hari" class="form-select" aria-label="Default select example">
            <option selected>Pilih Hari Untuk Melaksanakan Kelas</option>
            <option v-for="day in days" :key="day" >{{day}}</option>
          </select>
          <div id="namaHelp" class="form-text">ex : Laksanakan Kelas Pada Hari Senin</div>
        </div>
        <!-- Instruktur -->
        <div class="mb-3">
          <label for="nama_member" class="form-label">Pilih Instruktur Kelas</label>
          <select  v-model="jadwal.id_instruktur" class="form-select" aria-label="Default select example">
            <option selected default disabled>Pilih Instruktur Kelas</option>
            <option v-for="(instruktur,index) in instrukturs.value" :key="index" :value="instruktur.id_instruktur" >{{instruktur.nama_instruktur}}</option>
        </select>
          <div id="namaHelp" class="form-text">ex : Instruktur Penanggung Jawab Ucup Surucup</div>
        </div>
        <!-- Kelas -->
        <div class="mb-3">
          <label for="nama_member" class="form-label">Pilih Kelas</label>
          <select  v-model="jadwal.id_kelas" class="form-select" aria-label="Default select example">
            <option selected default disabled>Pilih Kelas </option>
            <option v-for="(kls,index) in kelas.value" :key="index" :value="kls.id_kelas">{{kls.jenis_kelas}}</option>
        </select>
          <div id="namaHelp" class="form-text">ex : Kelas Pilates</div>
        </div>
        <div class="mb-3">
          <label for="notelp" class="form-label">Jam Mulai</label>
          <input type="time" v-model="jadwal.jam_mulai" class="form-control" id="notelp">
          <div id="namaHelp" class="form-text">ex : 08:00</div>
        </div>
        <div class="mb-3">
          <label for="notelp" class="form-label">Jam Selesai</label>
          <input type="time" v-model="jadwal.jam_selesai" class="form-control" id="notelp">
          <div id="namaHelp" class="form-text">ex : 09:00</div>
        </div>
        <div class="d-flex justify-content-between">
          <back-button :className="'btn btn-dark'" @click="goBack"></back-button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
      <hr>
    </div>
</div>
</main>
</template>

<style scoped>

/* set width to match other form inputs */
input[type="date"] {
width: 100%;
padding: 0.375rem 0.75rem;
font-size: 1rem;
font-weight: 400;
line-height: 1.5;
color: #495057;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
border-radius: 0.25rem;
transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* hide default arrow */
input[type="date"]::-webkit-calendar-picker-indicator {
display: none;
}

/* use Bootstrap icon for date picker */
input[type="date"]::before {
content: "\f0ed";
font-family: "Material Design Icons";
font-weight: 400;
font-size: 1.25rem;
line-height: 1.5;
color: #6c757d;
position: absolute;
right: 0.75rem;
top: 50%;
transform: translateY(-50%);
pointer-events: none;
}

/* change border color on focus */
input[type="date"]:focus {
border-color: #80bdff;
box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* 
.content{
height: 100vh;
background-color: rgba(0,0,0,0.7  );
} */


.form-custom{
background-color: rgba(255,255,255,0.9);
border-radius: 10px;
}

</style>
