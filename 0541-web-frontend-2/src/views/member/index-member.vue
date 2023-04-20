<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import { onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {  ActionRouteToCreate, ActionViewDetail,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      TableData,
    },

    //Setup
    setup(){
      const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
      let members = ref([])
      onMounted(async () =>  {
        const dataRoute = "http://localhost:8000/api/member";
        const request = await axios.get(dataRoute)
        members.value = request.data.data 
        
        members.value.forEach((e)=>{
          const tanggalLengkap = e['tgl_lahir_member'].split(' ');
          const tanggal = new Date(tanggalLengkap[0])
          const formattedDate = tanggal.toLocaleDateString('en-GB');
          return e['tgl_lahir_member'] = formattedDate;
        })

        members.value.forEach((e)=>{
          e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Aktif' : 'Tidak Aktif'  
        })

      })

      // Mendefinisikan Route Tujuan MENG
      const ActionCreateMember =  ()=>{
        ActionRouteToCreate(router,'MemberCreate')
      }

      const deleteData = async (id) => {
        alert(id.id_pengguna)
        // lakukan aksi delete dengan menggunakan id dan additionalParam
      }

      const deleteDataWrapper = (deleteDataFunc, id /*, additionalParam*/ ) => {
        deleteDataFunc(id);
      }

      ActionDelete.functionAction = (id) => {
        // console.log(id)
        deleteDataWrapper(deleteData,id)
      }

      const actions = [
        ActionViewDetail,ActionUpdate,ActionDelete
    ]

      return{
        actions,
        router,
        members,
        ActionCreateMember
        // ActionCreate
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2 class="">Daftar Member</h2>
      <table-data 
      :context="'member'" 
      :data="members" 
      :column="['ID Member','Nama Member','Tanggal Lahir','Nomor Telepon','Status Aktif']" 
      :actions="actions" 
      :fields="['id_member','nama_member','tgl_lahir_member','no_telp_member','aktivasi']"
      :create="ActionCreateMember"
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
