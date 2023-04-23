<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
  import {  onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import { $toast } from '../../plugins/notifHelper';
  import createJadwalUmum from './create-jadwal-umum.vue';

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton,
      createJadwalUmum,
    },

    data() {
      return {
        toggle:true,
        toggleModeTabel : false,
    } 
},

    //Setup
    setup(){
      //Variable
      const router = useRouter('router'); 
      let jadwalPagi = ref([])
      let jadwalSore = ref([])
      let maxPagi = ref([]);
      let maxSore = ref([]);
      // let max = ref([])
      // //konversi Tanggal
      // function konversiTanggal(instruktur){
      //   instruktur.value.forEach((e)=>{
      //   const tanggalLengkap = e['tanggal_lahir_instruktur'].split(' ');
      //   const tanggal = new Date(tanggalLengkap[0])
      //   const formattedDate = tanggal.toLocaleDateString('en-GB');
      //   console.log(formattedDate)  
      //   return e['tanggal_lahir_instruktur'] = formattedDate;
      // })
      // }

      const getAllJadwal= async (message) => {
        const dataRoute = "http://localhost:8000/api/jadwalumum";
        const request = await axios.get(dataRoute)
        jadwalPagi.value = request.data.data.pagi
        maxPagi.value = Math.max(...Object.values(jadwalPagi.value).map(x => x.length)) 
        jadwalSore.value = request.data.data.sore
        maxSore.value = Math.max(...Object.values(jadwalSore.value).map(x => x.length)) 
        $toast.success(message)
      }
      onMounted(async () =>  {
        getAllJadwal('Mendapatkan data jadwal')
      })

      //Create

      //Update
      const updateDataCell= (data) => {
          console.log(data)
          router.push({name:'jadwal-umum-ubah',query:data})
      }

      //Delete
      const deleteDataCell = async ({id_jadwal_umum}) =>{
        console.log(id_jadwal_umum)
        const deleteRoute = `http://localhost:8000/api/jadwalumum/${id_jadwal_umum}`
        try{
          const deleteRequest = await axios.delete(deleteRoute)
          // alert(deleteRequest.data.message)
          $toast.success(deleteRequest.data.message)
          getAllJadwal('Tabel Data Jadwal di update')
        }catch{
          $toast.warning('Gagal Menghapus Data')
        }

      }

      return{
        jadwalPagi,
        jadwalSore,
        maxPagi,
        maxSore,
        updateDataCell,
        deleteDataCell
      }
    },
    computed:{
      displayedJadwal(){
        if(this.toggle){
          return this.jadwalPagi;
        }
        return this.jadwalSore
      },
      max(){
        if(this.toggle){ 
          return this.maxPagi;
        }
        return this.maxSore
    }
  }
})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Jadwal Umum'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2 class="">Jadwal</h2>
      <div class="class='container-fluid table-custom p-4 text-dark'">
        <!-- Button -->
        <div class="d-flex justify-content-between ">
          <router-link type="button"  class="btn btn-outline-dark" :to="{name:'jadwal-umum-tambah'}">Tambah Jadwal</router-link>
          <div>
            <button type="button"  class="btn btn-outline-dark" v-if="toggle" @click="toggle = !toggle">Jadwal Malam</button>              
            <button type="button"  class="btn btn-outline-dark" v-else @click="toggle = !toggle">Jadwal Pagi</button>              
          </div>              
        </div>
        <table class="table table-dark table-striped table-bordered table-hover mt-4 scrollme">
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
        </table>
        <div class="d-flex justify-content-between">
          <div>
            <button class="btn btn-primary" v-if="!toggleModeTabel" @click="toggleModeTabel = !toggleModeTabel">Mode Edit</button>
            <button class="btn btn-success" v-else @click=" toggleModeTabel =!toggleModeTabel">Mode Tampil</button>
          </div>
          <back-button className="btn btn-dark"></back-button>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.table-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}

/* .scrollme {
  overflow-x:scroll;
} */

.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
