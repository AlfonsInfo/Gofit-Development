<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
  import { reactive, onMounted } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {$toast} from '../../plugins/notifHelper.js'

  // import { ActionCreate,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },

    methods : {
        goBack() {
        if ($toast) {
        this.toast.goAway(0);
        }
      },
    },

    mounted(){
      window.onpopstate = () => {
        this.goBack();
      };
    },
    //Setup
    setup(){
      //router
      const router = useRouter(); 
      
      //Input 1 : Days
      const days = ['senin','selasa','rabu','kamis','jumat','minggu'];
      const selectedDay  = 'senin';
      
      //Input 2 : Instruktur
      const instrukturs = ({});
      const getAllInstruktur = async () => {
        const dataRoute = "http://localhost:8000/api/instruktur";
        const request = await axios.get(dataRoute)
        instrukturs.value = request.data.data 
      }
      //Input 3 : 
      const kelas = ({});
      const getAllKelas = async () => {
        const dataRoute = "http://localhost:8000/api/kelas";
        const request = await axios.get(dataRoute)
        kelas.value = request.data.kelas
      }
      
      const jadwal = reactive({
          'hari' : '',
          'id_instruktur' : '',
          'id_kelas' : '',
          'jam_mulai' : 'jam_selesai'
      })
      //Mounted
      onMounted(async () =>  {
          getAllInstruktur()
          getAllKelas()
      })
      const submitForm = (event) => {
        console.log(event)
        event.preventDefault(); // hindari default form submission
        // kode untuk memproses data form
        console.log(jadwal)
        storeJadwal()
      }

      function isValid({nama_member,tgl_lahir_member,no_telp_member}){
        let status = true;  
        console.log(nama_member,tgl_lahir_member,no_telp_member)
        if (!nama_member) {
          $toast.warning('Nama member harus diisi');
          status = false;
        }
        // const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!tgl_lahir_member) {
          $toast.warning('Tanggal lahir member harus diisi');
          status = false;
        }
        if (!no_telp_member) {
          $toast.warning('No telp member harus diisi');
          status = false;
        }
        return status;
      }


      function isNotConflict(jadwal){
        let status = true;
          //cek
        return status;
      }



      const storeJadwal = async() => {
        const statusValidate = isValid(jadwal)
        const statusJadwalInstruktur = isNotConflict(jadwal)
        if(statusValidate && statusJadwalInstruktur){
          try{
            const post = "http://127.0.0.1:8000/api/member"; 
            const request = await axios.post(post,jadwal); // ; 
            $toast.success(request.data.message)
          }catch{
            $toast.warning('Gagal Menambahkan Data')
          }
        }
      }

      return{
        router,
        jadwal,
        storeJadwal,
        submitForm,

        //day
        days,
        selectedDay,
        kelas,
        instrukturs
        
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit -  Tambah Data Jadwal'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2></h2>
      <div  class= 'container-fluid form-custom p-4 text-dark'>
        <h3 class="title">Form Tambah Jadwal <span class="mdi mdi-calendar"></span></h3>
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
              <option v-for="(instruktur,index) in instrukturs.value" :key="index" >{{instruktur.nama_instruktur}}</option>
          </select>
            <div id="namaHelp" class="form-text">ex : Instruktur Penanggung Jawab Ucup Surucup</div>
          </div>
          <!-- Kelas -->
          <div class="mb-3">
            <label for="nama_member" class="form-label">Pilih Kelas</label>
            <select  v-model="jadwal.id_kelas" class="form-select" aria-label="Default select example">
              <option selected default disabled>Pilih Kelas </option>
              <option v-for="(kls,index) in kelas.value" :key="index" >{{kls.jenis_kelas}}</option>
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


.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}


.form-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}

</style>
