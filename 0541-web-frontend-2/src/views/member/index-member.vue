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
      let members = ref([])
      onMounted(async () =>  {
        const dataRoute = "http://localhost:8000/api/member";
        const request = await axios.get(dataRoute)
        members.value = request.data.data 
        
        members.value.forEach((e)=>{
          e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Ya' : 'Tidak'  
        })

      })
      console.log(ActionCreate)
      const actions = [
        ActionCreate,ActionUpdate,ActionDelete
    ]

      return{
        actions,
        router,
        members
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
      <table-data :context="'member'" :data="members" :column="['ID Member','Nama Member']" :actions="actions" :fields="['id_member','nama_member']"></table-data>
      <!-- <div>
        Search Section
      </div >
        <div class= 'container-fluid table-custom p-4'>
          <table class="table table-striped table-bordered table-hover mt-4">
            <thead class="table table-dark">
              <tr>
                <th scope="col">ID Member</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Tanggal Lahir Member</th>
                <th scope="col">No Telp Member</th>
                <th scope="col">Status Aktif</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(data ,id) in members" :key ="id">
                <td>{{ data.id_member }}</td>
                <td>{{ data.nama_member}}</td>
                <td>{{ data.tgl_lahir_member}}</td>
                <td>{{ data.no_telp_member}}</td>
                <td>{{ data.tgl_kadeluarsa_aktivasi == null ? 'Ya' : 'Tidak'}}</td>
                <td>Detail | Edit | Hapus</td>
              </tr>
            </tbody>
          </table>
        </div> -->
    </div>
  </main>
</template>

<style scoped>




.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
