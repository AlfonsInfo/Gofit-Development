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
      

      //Container Data Jadwal Baru
      const jadwal = reactive({
          'hari' : '',
          'id_instruktur' : '',
          'id_kelas' : '',
          'jam_mulai' : '',
          'jam_selesai' : '',
      })

      const jadwals  = reactive({})
      const getAllJadwal= async () => {
        const dataRoute = "http://localhost:8000/api/jadwalumum";
        const request = await axios.get(dataRoute)
        jadwals.value = request.data.data
      }
       
      //Mounted
      onMounted(async () =>  {  
          getAllInstruktur();
          getAllKelas();
          getAllJadwal();


      })
      const submitForm = (event,) => {
        console.log(event)
        event.preventDefault(); // hindari default form submission
        // kode untuk memproses data form
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

        //Default tidak ada konflik
        let status = true;

        //Mapping data ke content
        let content = Object.values(jadwals.value).flatMap(data => Object.values(data)).flat();

        console.log('input jadwal', jadwal)

        let filteredData = content.filter((values) => {
            const jadwalMulaiA = parseInt(jadwal.jam_mulai.replace(':',''));
            const jadwalSelesaiA = parseInt(jadwal.jam_selesai.replace(':',''))
            const jadwalMulaiB = parseInt(values.jam_mulai.replace(':',''));
            const jadwalSelesaiB = parseInt(values.jam_selesai.replace(':',''))


            const conditionHari = (values.hari == jadwal.hari) ? true : false
            const conditionInstruktur = (values.id_instruktur== jadwal.id_instruktur) ? true : false

            //Jadwal Konflik 1
            const conditionjadwalConflict1 = ((jadwalMulaiB >= jadwalMulaiA ) && jadwalSelesaiA >= jadwalMulaiB)
            const conditionJadwalConflict2 = ((jadwalMulaiA <= jadwalMulaiB) && jadwalSelesaiA > jadwalSelesaiB)
            const conditionJadwalConflict3 = ((jadwalMulaiA <= jadwalSelesaiB) && jadwalSelesaiA >= jadwalMulaiB)

            

            if(conditionHari && conditionInstruktur && (conditionjadwalConflict1 || conditionJadwalConflict2 || conditionJadwalConflict3)){
              console.log(jadwalMulaiA, jadwalMulaiB , jadwalSelesaiA, jadwalSelesaiB)
              console.log( conditionjadwalConflict1, conditionJadwalConflict2, conditionJadwalConflict2)
              if(conditionjadwalConflict1)
                $toast.warning('Jadwal Bentrok : Jadwal Baru Yang dinputkan bentrok dengan jadwal Mulai Kelas ' + values.kelas.jenis_kelas)
              if(conditionJadwalConflict2)
                $toast.warning('Jadwal Bentrok  ' + values.kelas.jenis_kelas)
              return values
            }
            return null
        })
    console.log(filteredData)
    if(filteredData.length > null)
    {
      status = false;
    }
    console.log(status)
    return status;
}




      const storeJadwal = async() => {
        // const statusValidate = isValid(jadwal)
        const statusJadwalInstruktur = isNotConflict(jadwal)
        console.log(statusJadwalInstruktur)
        // if( statusJadwalInstruktur){
        //   try{
        //     const post = "http://127.0.0.1:8000/api/member"; 
        //     const request = await axios.post(post,jadwal); // ; 
        //     $toast.success(request.data.message)
        //   }catch{
        //     $toast.warning('Gagal Menambahkan Data')
        //   }
        // }
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


.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}


.form-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}

</style>
