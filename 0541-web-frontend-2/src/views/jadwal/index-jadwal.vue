<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import { computed, onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import { ActionRouteToCreate,ActionUpdate,ActionDelete} from '../../data/actionData'
  import { $toast } from '../../plugins/notifHelper';

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      TableData,
    },

    data() {
  return {
    data: [
      { hari: 'Senin', sesi1: '', sesi2: '', sesi3: '' },
      { hari: 'Selasa', sesi1: '', sesi2: '', sesi3: '' },
      { hari: 'Rabu', sesi1: '', sesi2: '', sesi3: '' },
      { hari: 'Kamis', sesi1: '', sesi2: '', sesi3: '' },
      { hari: 'Jumat', sesi1: '', sesi2: '', sesi3: '' }
    ]
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
      // const ActionCreateInstruktur =  ()=>{
      //   ActionRouteToCreate(router,'instruktur-tambah') 
      // }

      //Update


      //Delete
      // const deleteData = async ({id_instruktur}) => {
      //   console.log(id_instruktur)
      //   const deleteRoute = `http://localhost:8000/api/instruktur/${id_instruktur}`
      //   try{
      //     const deleteRequest = await axios.delete(deleteRoute)
      //     $toast.success(deleteRequest.data.message)
      //     getAllInstruktur('Tabel Data Member di update')
      //   }catch{
      //     $toast.warning('Gagal Menghapus Data')
      //   }
      // }


    //   ActionDelete.functionAction = (instruktur) => {
    //     deleteData(instruktur)
    //     // deleteDataWrapper(deleteData,id)
    //   }

    //   const actions = [
    //     ActionUpdate,ActionDelete
    // ]

      return{
        jadwalPagi,
        jadwalSore,
        maxPagi,
        maxSore
    //     ActionCreateInstruktur,
    //     actions,
    //     router,
    //     instrukturs
      }
    },
    computed:{

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
        <table class="table table-striped table-bordered table-hover mt-4">
          <thead>
            <tr>
              <th></th>
              <th v-for="i in maxPagi" :key="'sesi-'+i">Jadwal {{i}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(jd,index) in jadwalPagi" :key="index">
              <th scope="row">{{index}}</th>
              <td v-for="(column,idx) in jd" :key="idx"> 
                {{column.jam_mulai}}
                {{column.kelas.jenis_kelas }}  
                {{ column.instruktur.nama_instruktur }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="class='container-fluid table-custom p-4 text-dark'">
        <table class="table table-striped table-bordered table-hover mt-4">
          <thead>
            <tr>
              <th></th>
              <th v-for="i in maxSore" :key="'sesi-'+i">Jadwal {{i}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(jd,index) in jadwalSore" :key="index">
              <th scope="row">{{index}}</th>
              <td v-for="(column,idx) in jd" :key="idx"> 
                {{column.jam_mulai}}
                {{column.kelas.jenis_kelas }}  
                {{ column.instruktur.nama_instruktur }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<style scoped>
.table-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}



.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
