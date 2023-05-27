  <script>
import { HomeNavbar, TableData,  ref, useRouter, 
  reactive,inject,$toast,onMounted,ActionRouteToCreate , 
  ActionDelete,ActionUpdate, defineComponent, customSwalSuccess  ,CustomDateTimeFormatter , customSwal } from '@/plugins/global.js'

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
      const state = reactive({
        searchInput : '',
      })      

      
      function konversiTanggal(instruktur){
        instruktur.value.forEach((e)=>{
        e['tanggal_lahir_instruktur'] = CustomDateTimeFormatter.reverseDate(e['tanggal_lahir_instruktur'],'/');
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

      //Delete
      const deleteData = async ({id_instruktur}) => {
        try{

          const deleteRoute = `/instruktur/${id_instruktur}`
          const deleteRequest = await http.delete(deleteRoute)
          await customSwalSuccess(deleteRequest.data.message)
          getAllInstruktur('Tabel Data Member di update')
        }catch{
          $toast.warning('Gagal Menghapus Data')
        }
      }


      ActionDelete.functionAction = (instruktur) => {
        customSwal('Apakah Anda yakin ingin menghapus data ini?','warning','red','yakin',deleteData, instruktur)
      }

      const actions = [
        ActionUpdate,ActionDelete
      ]

      return{
        ActionCreateInstruktur,
        actions,
        router,
        instrukturs,
        state
      }
    },

    computed : {
      displayedInstruktur() {
        const searchKeyword = this.state.searchInput.toLowerCase();
        return this.instrukturs.filter(instruktur => {
          const instrukturString = Object.values(instruktur).join(' ').toLowerCase();
          return instrukturString.includes(searchKeyword);
    });
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
      <div class="input-group mt-3 mb-2">
        <input type="search" class="form-control rounded me-2 " placeholder="Cari Member" aria-label="Search" aria-describedby="search-addon" v-model="state.searchInput"/>
      </div>
      <table-data 
        :context="'instruktur'" 
        :data="displayedInstruktur" 
        :column="[/*'ID Instruktur',*/ 'Nama Instruktur','Tanggal Lahir','Alamat','No Telp']" 
        :actions="actions" 
        :fields="[/*'id_instruktur',*/'nama_instruktur','tanggal_lahir_instruktur','alamat_instruktur','no_telp_instruktur']"
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
