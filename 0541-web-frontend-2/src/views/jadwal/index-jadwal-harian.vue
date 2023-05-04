<script>
import { HomeNavbar, useRouter, ref ,onMounted, $toast, defineComponent, BackButton , inject, reactive} from '@/plugins/global.js'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton,
    },

    data() {
      return {
        
      } 
},

    //Setup
    setup(){
      //Variable
      const router = useRouter('router'); 
      const http = inject('$http')
      let jadwalHarian = ref([])
      let maxJadwal= ref([]);
      const state = reactive({
      searchInput : '',
      // modalConfirm : false,
      // modalReaction : false,
    })


      const querySearch = async () => {

      }
      //cek http dan $http update~~~~~~~`
      const getAllJadwal= async (message) => {
        const dataRoute = "/jadwalharian";
        const response= await http.get(dataRoute)
        jadwalHarian.value = response.data.data
        
        console.log(jadwalHarian.value)
        // const filterData = Object.value(jadwalHarian.value).filter((tanggal,{id_jadwal_umum})=> tanggal == '2023-05-04');
        // console.log(filterData)
        maxJadwal.value = Math.max(...Object.values(jadwalHarian.value).map(x => x.length)) 
        $toast.success(message)
      }
      onMounted(async () =>  {
        getAllJadwal('Mendapatkan data jadwal')
      })

      //Create

      //Update
      const updateDataCell = (data) => {
          console.log(data)
          router.push({name:'jadwal-umum-ubah',query:data})
      }

      //Delete
      const deleteDataCell = async ({id_jadwal_umum}) =>{
        const confirmDelete = confirm('Apakah Yakin ingin menghapus jadwal ini ? ');

        if(confirmDelete){
          const deleteRoute = `/jadwalumum/${id_jadwal_umum}`
          try{
            const deleteRequest = await http.delete(deleteRoute)
            $toast.success(deleteRequest.data.message)
            getAllJadwal('Tabel Data Jadwal di update')
          }catch{
            $toast.warning('Gagal Menghapus Data')
          }
        }

      }

      return{
        // jadwalPagi,
        // jadwalSore,
        state,
        jadwalHarian,
        maxJadwal,
        // maxSore,
        updateDataCell,
        deleteDataCell
      }
    },
    computed:{
      displayedJadwal(){
        let searchInput = this.state.searchInput;
        let contentJadwal = Object.entries(this.jadwalHarian);
        // let Content = {};
      if (searchInput !== '') {
        contentJadwal = contentJadwal.filter(([key, value]) => {
          return key.includes(searchInput) ||
            Object.values(value).some(function(obj){
              return obj.jadwal_umum.kelas.jenis_kelas.includes(searchInput) ||
              obj.jadwal_umum.instruktur.nama_instruktur.includes(searchInput)
            } 
            );
        }).map(([key, value]) => [key, value.filter(obj => {
            return obj.jadwal_umum.kelas.jenis_kelas.includes(searchInput);
        })]);
      }      
        return contentJadwal;
      }
    // );
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
      <div class="input-group mt-3 mb-2">
        <input type="search" class="form-control rounded me-2 " placeholder="Cari Jadwal" aria-label="Search" aria-describedby="search-addon" v-model="state.searchInput"/>
      <button class="btn btn-primary">Cari Jadwal</button>
      </div>

      <div class="class='container-fluid table-custom p-4 text-dark'">
        <!-- Button -->
        <div class="d-flex justify-content-between ">
          <router-link type="button"  class="btn btn-outline-dark" :to="{name:'jadwal-umum-tambah'}">Tambah Jadwal</router-link>
          <!-- <div>
            <button type="button"  class="btn btn-outline-dark" v-if="toggle" @click="toggle = !toggle">Jadwal Malam</button>              
            <button type="button"  class="btn btn-outline-dark" v-else @click="toggle = !toggle">Jadwal Pagi</button>              
          </div>               -->
        </div>
        <table class="table table-dark table-striped table-bordered table-hover mt-4 scrollme">
          <thead>
            <tr class="text-white bg-dark text-center">
              <th>#</th>
              <th v-for="i in maxJadwal" :key="i" >Jadwal {{i}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(jd,index) in displayedJadwal" :key="index">
              <th scope="row" class="text-white bg-dark text-center">
                <p>
                  {{jd[0]}} {{ new Date(jd[0]).toLocaleDateString('en-US', {weekday: 'long'}) }}
                </p>
              </th>
              <td v-for="(column,idx) in jd[1]" :key="idx">
                <p>
                  Kelas : {{ column.jadwal_umum.kelas.jenis_kelas }}
                </p>
                <p>
                  Instruktur : {{column.jadwal_umum.instruktur.nama_instruktur}}
                </p>
                <p>{{ column.jadwal_umum.jam_mulai }} - {{ column.jadwal_umum.jam_selesai }}</p>
              </td>
              <td v-for="i in (maxJadwal - jd[1].length)" :key="i" class="text-center">*</td>
              
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-between">
          <!-- <div>
            <button class="btn btn-primary" v-if="!toggleModeTabel" @click="toggleModeTabel = !toggleModeTabel">Mode Edit</button>
            <button class="btn btn-success" v-else @click=" toggleModeTabel =!toggleModeTabel">Mode Tampil</button>
          </div> -->
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
