<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import { onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import { ActionCreate,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      TableData,
    },

    //Setup
    setup(){
      const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
      let ijinInstruktur = ref([])
      onMounted(async () =>  {
        const dataRoute = "http://localhost:8000/api/ijinInstruktur";
        const request = await axios.get(dataRoute)
        ijinInstruktur.value = request.data.data 
        // console.log(ijinInstruktur.value)

      })
      console.log(ActionCreate)
      const actions = [
        ActionCreate,ActionUpdate,ActionDelete
    ]

      return{
        actions,
        router,
        ijinInstruktur
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Instruktur'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2 class="">Daftar Member</h2>
      <table-data 
        :context="'instruktur'" 
        :data="ijinInstruktur" 
        :column="['ID Ijin','Instruktur','Instruktur Pengganti','Jadwal Harian','Tanggal Pengajuan','Status Ijin']" 
        :fields="['id_ijin',['instruktur','nama_instruktur'],['instruktur_pengganti','nama_instruktur'],'id_jadwal_harian','tanggal_pengajuan','status_ijin']"
        :object-field="'nama_instruktur'"
        :actions="actions" 
        ></table-data>
    </div>
  </main>
</template>

<style scoped>




.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
