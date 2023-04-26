<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import { onMounted ,ref, inject } from 'vue';
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

    //Setup
    setup(){
      //Variable
      const router = useRouter('router'); 
      const http = inject("$http");
      let instrukturs = ref([])
      
      //konversi Tanggal
      function konversiTanggal(instruktur){
        instruktur.value.forEach((e)=>{
        const tanggalLengkap = e['tanggal_lahir_instruktur'].split(' ');
        const tanggal = new Date(tanggalLengkap[0])
        const formattedDate = tanggal.toLocaleDateString('en-GB');
        console.log(formattedDate)  
        return e['tanggal_lahir_instruktur'] = formattedDate;
      })
      }

      const getAllInstruktur = async (message) => {
        const dataRoute = "/instruktur";
        const request = await http.get(dataRoute)
        instrukturs.value = request.data.data 
        konversiTanggal(instrukturs)
        $toast.success(message)
      }
      onMounted(async () =>  {
          getAllInstruktur('Berhasil Menampilkan Seluruh Data Instruktur')
      })

      //Create
      const ActionCreateInstruktur =  ()=>{
        ActionRouteToCreate(router,'instruktur-tambah') 
      }

      //Update


      //Delete
      const deleteData = async ({id_instruktur}) => {
        console.log(id_instruktur)
        const deleteRoute = `/instruktur/${id_instruktur}`
        try{
          const deleteRequest = await http.delete(deleteRoute)
          $toast.success(deleteRequest.data.message)
          getAllInstruktur('Tabel Data Member di update')
        }catch{
          $toast.warning('Gagal Menghapus Data')
        }
      }


      ActionDelete.functionAction = (instruktur) => {
        deleteData(instruktur)
        // deleteDataWrapper(deleteData,id)
      }

      const actions = [
        ActionUpdate,ActionDelete
    ]

      return{
        ActionCreateInstruktur,
        actions,
        router,
        instrukturs
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
      <h2 class="">Daftar Instruktur</h2>
      <table-data 
        :context="'instruktur'" 
        :data="instrukturs" 
        :column="['ID Instruktur','Nama Instruktur','Tanggal Lahir','Alamat','No Telp']" 
        :actions="actions" 
        :fields="['id_instruktur','nama_instruktur','tanggal_lahir_instruktur','alamat_instruktur','no_telp_instruktur']"
        :create="ActionCreateInstruktur"
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
