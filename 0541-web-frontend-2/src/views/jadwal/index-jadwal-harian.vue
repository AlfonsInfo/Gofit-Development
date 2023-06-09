<script>
import { HomeNavbar,  ref ,onMounted, $toast, defineComponent, BackButton , inject, reactive
        , Swal } from '@/plugins/global.js'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton,
    },

    data() {
      return {
        toggleModeTabel  : false
      } 
},

    //Setup
    setup(){
      //Variable
      const http = inject('$http')
      let jadwalHarian = ref([])
      let maxJadwal= ref([]);
      const state = reactive({
      searchInput : '',
    })


      //cek http dan $http update~~~~~~~`
      const getAllJadwal= async (message) => {
        const dataRoute = "/jadwalharian";
        const response= await http.get(dataRoute)
        jadwalHarian.value = response.data.data
        
        console.log(jadwalHarian.value)
        maxJadwal.value = Math.max(...Object.values(jadwalHarian.value).map(x => x.length)) 
        $toast.success(message)
      }
      onMounted(async () =>  {
        getAllJadwal('Mendapatkan data jadwal')
      })

      const confirmChangeStatus = async ({id_jadwal_harian}) => {
        //Confirm
        const result = await Swal.fire({
          title: 'Apakah Anda yakin ingin meliburkan jadwal ini?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Liburkan',
          cancelButtonText: 'Batal',
        })
        //Jika di confirm
      if (result.isConfirmed) {
        const url = `/jadwalharianlibur/${id_jadwal_harian}`
        console.log(url);
        const response = await http.get(url)
        getAllJadwal('Tabel Data Jadwal di update')
        $toast.success(response.data.message)
      // Tampilkan notifikasi SweetAlert setelah data dihapus
    
      Swal.fire({
        title: 'Jadwal Berhasil diliburkan!',
        icon: 'success',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
      })
    
    }
  }

  const generateJadwal = async () => {
        //Confirm
        const result = await Swal.fire({
          title: 'Apakah Anda yakin ingin melakukan generate jadwal untuk minggu ini ?',
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: 'blue',
          confirmButtonText: 'Generate',
          cancelButtonText: 'Batal',
        })
      if (result.isConfirmed) {
        try{
          const url = `/jadwalharian`
          const response = await http.post(url,{})
          console.log(response)
          getAllJadwal('Tabel Data Jadwal Berhasil digenerate')
          $toast.success(response.data.message)
          Swal.fire({
            title: 'Data berhasil digenerate!',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
          })
        }catch(e){
          console.log(e.response.data.message)
          $toast.info('Gagal Generate')
        }
      // Tampilkan notifikasi SweetAlert setelah data dihapus
    
    
    }
  }

    // const changeStatus = async(id_jadwal_harian) => {

    // }

      

      return{
        state,
        jadwalHarian,
        confirmChangeStatus,
        maxJadwal,
        generateJadwal
        // changeStatus
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
      <h2 class="">Jadwal Harian</h2>
      <div class="input-group mt-3 mb-2">
        <input type="search" class="form-control rounded me-2 " placeholder="Cari Jadwal" aria-label="Search" aria-describedby="search-addon" v-model="state.searchInput"/>
      <button class="btn btn-primary" @click="generateJadwal">Generate Jadwal +</button>
      </div>

      <div class="class='container-fluid table-custom p-4 text-dark'">
        <!-- Button -->
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
                <p>{{ column.jadwal_umum.jam_mulai }} - {{ column.jadwal_umum.jam_selesai }}</p>
                <p v-if="column.ijin_instruktur == null"> 
                  Instruktur : {{column.jadwal_umum.instruktur.nama_instruktur}}
                </p>
                <p v-else-if="column.ijin_instruktur.status_ijin == 'Perijinan dikonfirmasi'" class="bg-success rounded p-2">
                  <!-- ijin instruktur telah dikonfirmasi -->
                  {{ column.ijin_instruktur.instruktur_pengganti.nama_instruktur }}
                  (menggantikan {{ column.ijin_instruktur.instruktur.nama_instruktur }})
                  <!-- Instruktur Test : {{column.jadwal_umum}} -->
                  <!-- (menggantikan {{ column.jadwal_umum.ijin_instruktur.instrukturPengganti.nama_instruktur }}) -->
                </p>
                <p v-if="column.status == 'diliburkan'" class="bg-danger rounded p-2"> Diliburkan🙏 </p>
                <div v-show="toggleModeTabel" v-if="column.status != 'diliburkan'">
                  <button class="btn btn-warning m-2" @click.prevent="confirmChangeStatus(column)">Liburkan</button>
                </div>
              </td>
              <td v-for="i in (maxJadwal - jd[1].length)" :key="i" class="text-center">*</td>
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
    